// Declare quill globally
var quill;
var quillInitialized = false;
var editQuill;
var editQuillInitialized = false;

$(document).ready(function() {
    console.log('=== DOCUMENT READY ===');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Upload modal exists:', $('#uploadKaryaModal').length);

    // Initialize DataTable
    var table = $('#activityTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        scrollX: false,
        autoWidth: false,
        ajax: window.activityRoute,
        columns: [
            { data: 'title', name: 'title', className: 'align-middle' },
            { data: 'kategori', name: 'kategori', className: 'align-middle' },
            {
                data: 'description',
                name: 'description',
                className: 'align-middle',
                render: function(data, type, row) {
                    return data || '-';
                }
            },
            { data: 'kontributor', name: 'kontributor', className: 'align-middle' },
            {
                data: 'keterangan',
                name: 'keterangan',
                className: 'align-middle',
                render: function(data) {
                    return data || '-';
                }
            },
            {
                data: 'status',
                name: 'status',
                className: 'align-middle text-center'
            },
            {
                data: 'aksi',
                name: 'aksi',
                orderable: false,
                searchable: false,
                className: 'align-middle'
            }
        ],
        language: {
            processing: "Memproses...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            loadingRecords: "Memuat...",
            zeroRecords: "Tidak ada data yang ditemukan",
            emptyTable: "Belum ada karya yang diunggah",
            paginate: {
                first: "Pertama",
                previous: "Sebelumnya",
                next: "Selanjutnya",
                last: "Terakhir"
            }
        },
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        order: [[0, 'desc']]
    });

    // Handle Detail button click
    $(document).on('click', '.btn-detail', function(e) {
        e.preventDefault();
        var karyaId = $(this).data('id');

        // Load karya details via AJAX
        $.ajax({
            url: '/karya/' + karyaId,
            method: 'GET',
            success: function(response) {
                // Populate detail modal
                $('#detail_title').text(response.title);
                $('#detail_kategori').text(response.kategori ? response.kategori.nama : '-');
                $('#detail_jenis_karya').text(response.jenis_karya ? response.jenis_karya.nama : '-');
                $('#detail_description').html(response.description);
                $('#detail_kontributor').text(response.source || response.user.name);
                $('#detail_pembimbing').text(response.pembimbing ? response.pembimbing.name : '-');
                $('#detail_date').text(response.date);
                $('#detail_language').text(response.language ? response.language.nama : '-');
                $('#detail_rights').text(response.rights || '-');
                $('#detail_relation').text(response.relation || '-');
                $('#detail_coverage').text(response.coverage || '-');
                $('#detail_source').text(response.source || '-');
                $('#detail_status').html('<span class="badge ' +
                    (response.status === 'Terpublish' ? 'bg-success' :
                     response.status === 'Menunggu' ? 'bg-warning' : 'bg-danger') +
                    '">' + response.status + '</span>');
                $('#detail_keterangan').text(response.keterangan || '-');

                // Show files
                var filesHtml = '';
                if (response.files && response.files.length > 0) {
                    response.files.forEach(function(file) {
                        // Extract filename from file_path
                        var fileName = file.file_path.split('/').pop();
                        var fileUrl = '/files/' + fileName + '/download';

                        filesHtml += '<div class="mb-2">' +
                            '<a href="' + fileUrl + '" target="_blank" class="btn btn-sm btn-outline-primary">' +
                            '<i class="bi bi-eye"></i> Lihat Karya' +
                            '</a></div>';
                    });
                } else {
                    filesHtml = '<p class="text-muted">Tidak ada file</p>';
                }
                $('#detail_files').html(filesHtml);

                // Show modal
                $('#detailKaryaModal').modal('show');
            },
            error: function() {
                alert('Gagal memuat detail karya');
            }
        });
    });

    // Handle Edit button click
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var karyaId = $(this).data('id');

        // Load karya details via AJAX
        $.ajax({
            url: '/karya/' + karyaId + '/edit',
            method: 'GET',
            success: function(response) {
                // Populate edit modal
                $('#edit_karya_id').val(response.id);
                $('#edit_title').val(response.title);
                $('#edit_jenis_karya').val(response.jenis_karya_id);
                $('#edit_kategori').val(response.kategori_id);
                $('#edit_source').val(response.source);
                $('#edit_date').val(response.date);
                $('#edit_pembimbing_id').val(response.pembimbing_id);
                $('#edit_rights').val(response.rights);
                $('#edit_relation').val(response.relation);
                $('#edit_language_id').val(response.language_id);
                $('#edit_coverage').val(response.coverage);

                // Set Quill content
                if (editQuill) {
                    editQuill.root.innerHTML = response.description;
                }

                // Update form action
                $('#editKaryaForm').attr('action', '/karya/' + karyaId);

                // Show modal
                $('#editKaryaModal').modal('show');
            },
            error: function() {
                alert('Gagal memuat data karya');
            }
        });
    });

    // Handle Jenis Karya manual input toggle (Upload)
    $(document).on('change', '#jenis_karya', function() {
        if ($(this).val() === 'manual_input') {
            $('#jenis_karya_manual').removeClass('d-none').attr('required', true);
            $(this).removeAttr('required');
        } else {
            $('#jenis_karya_manual').addClass('d-none').removeAttr('required');
            if ($(this).val() === '') {
                $(this).attr('required', true);
            }
        }
    });

    // ============================================
    // KATEGORI AUTOCOMPLETE FUNCTIONALITY (Upload)
    // ============================================

    const kategoriInput = document.getElementById('kategori_input');
    const kategoriSuggestions = document.getElementById('kategori_suggestions');
    const kategoriIdField = document.getElementById('kategori_id');
    const kategoriManualField = document.getElementById('kategori_manual');

    if (kategoriInput && kategoriSuggestions) {
        let selectedIndex = -1;

        // Handle input for autocomplete
        kategoriInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            selectedIndex = -1;

            if (query.length === 0) {
                kategoriSuggestions.classList.remove('show');
                kategoriSuggestions.innerHTML = '';
                kategoriIdField.value = '';
                kategoriManualField.value = '';
                return;
            }

            // Filter kategoris that match the query
            const matches = window.kategorisData.filter(s =>
                s.nama.toLowerCase().includes(query)
            );

            let html = '';

            // Show matching suggestions
            matches.forEach((kategori, index) => {
                const highlightedName = kategori.nama.replace(
                    new RegExp(`(${query})`, 'gi'),
                    '<span class="match">$1</span>'
                );
                html += `<div class="autocomplete-suggestion" data-id="${kategori.id}" data-nama="${kategori.nama}" data-index="${index}">${highlightedName}</div>`;
            });

            // Check if exact match exists
            const exactMatch = window.kategorisData.find(s =>
                s.nama.toLowerCase() === query
            );

            // If no exact match, offer to create new
            if (!exactMatch && query.length > 0) {
                html += `<div class="autocomplete-suggestion autocomplete-new-item" data-id="new" data-nama="${this.value.trim()}" data-index="${matches.length}">+ Tambahkan "${this.value.trim()}" sebagai kategori baru</div>`;
            }

            kategoriSuggestions.innerHTML = html;
            kategoriSuggestions.classList.add('show');
        });

        // Handle click on suggestion
        kategoriSuggestions.addEventListener('click', function(e) {
            const suggestion = e.target.closest('.autocomplete-suggestion');
            if (suggestion) {
                const id = suggestion.dataset.id;
                const nama = suggestion.dataset.nama;

                kategoriInput.value = nama;

                if (id === 'new') {
                    kategoriIdField.value = 'manual_input';
                    kategoriManualField.value = nama;
                } else {
                    kategoriIdField.value = id;
                    kategoriManualField.value = '';
                }

                kategoriSuggestions.classList.remove('show');
                kategoriSuggestions.innerHTML = '';
            }
        });

        // Handle keyboard navigation
        kategoriInput.addEventListener('keydown', function(e) {
            const suggestions = kategoriSuggestions.querySelectorAll('.autocomplete-suggestion');

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, suggestions.length - 1);
                updateSelectedSuggestion(suggestions);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, 0);
                updateSelectedSuggestion(suggestions);
            } else if (e.key === 'Enter' && selectedIndex >= 0) {
                e.preventDefault();
                suggestions[selectedIndex].click();
            } else if (e.key === 'Escape') {
                kategoriSuggestions.classList.remove('show');
            }
        });

        function updateSelectedSuggestion(suggestions) {
            suggestions.forEach((s, i) => {
                s.classList.toggle('active', i === selectedIndex);
            });
        }

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!kategoriInput.contains(e.target) && !kategoriSuggestions.contains(e.target)) {
                kategoriSuggestions.classList.remove('show');

                // If user typed something but didn't select, treat as new
                if (kategoriInput.value.trim() && !kategoriIdField.value) {
                    const inputValue = kategoriInput.value.trim();
                    const exactMatch = window.kategorisData.find(s =>
                        s.nama.toLowerCase() === inputValue.toLowerCase()
                    );

                    if (exactMatch) {
                        kategoriIdField.value = exactMatch.id;
                        kategoriManualField.value = '';
                        kategoriInput.value = exactMatch.nama;
                    } else {
                        kategoriIdField.value = 'manual_input';
                        kategoriManualField.value = inputValue;
                    }
                }
            }
        });
    }

    // Handle Jenis Karya manual input toggle (Edit)
    $(document).on('change', '#edit_jenis_karya', function() {
        if ($(this).val() === 'manual_input') {
            $('#edit_jenis_karya_manual').removeClass('d-none').attr('required', true);
            $(this).removeAttr('required');
        } else {
            $('#edit_jenis_karya_manual').addClass('d-none').removeAttr('required');
            if ($(this).val() === '') {
                $(this).attr('required', true);
            }
        }
    });

    // Handle Kategori manual input toggle (Edit)
    $(document).on('change', '#edit_kategori', function() {
        if ($(this).val() === 'manual_input') {
            $('#edit_kategori_manual').removeClass('d-none').attr('required', true);
            $(this).removeAttr('required');
        } else {
            $('#edit_kategori_manual').addClass('d-none').removeAttr('required');
            if ($(this).val() === '') {
                $(this).attr('required', true);
            }
        }
    });

    // Submit upload form with Quill content and AJAX with progress bar
    $(document).on('submit', '#uploadKaryaForm', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Transfer Quill content to hidden textarea
        $('#description').val(quill.root.innerHTML);

        // Validate Quill content
        if (quill.getText().trim().length === 0) {
            alert('Deskripsi harus diisi!');
            return false;
        }

        // Validate kategori input
        const kategoriInputVal = $('#kategori_input').val().trim();
        const kategoriIdVal = $('#kategori_id').val();

        if (!kategoriInputVal) {
            alert('Kategori harus diisi!');
            $('#kategori_input').focus();
            return false;
        }

        // Auto-fill kategori values if not selected from suggestions
        if (!kategoriIdVal && kategoriInputVal) {
            const exactMatch = window.kategorisData.find(s =>
                s.nama.toLowerCase() === kategoriInputVal.toLowerCase()
            );

            if (exactMatch) {
                $('#kategori_id').val(exactMatch.id);
                $('#kategori_manual').val('');
            } else {
                $('#kategori_id').val('manual_input');
                $('#kategori_manual').val(kategoriInputVal);
            }
        }

        // Validate file input
        const fileInput = document.getElementById('files');
        if (!fileInput.files.length) {
            alert('Harap pilih file untuk diunggah!');
            return false;
        }

        // Validate file sizes (15MB per file)
        for (let i = 0; i < fileInput.files.length; i++) {
            const fileSize = fileInput.files[i].size / 1024 / 1024; // Convert to MB
            if (fileSize > 15) {
                alert('Ukuran file "' + fileInput.files[i].name + '" melebihi 15MB!');
                return false;
            }
        }

        // Validate thumbnail file size and type
        // const thumbnailInput = document.getElementById('thumbnail');
        // if (thumbnailInput && thumbnailInput.files.length > 0) {
        //     const file = thumbnailInput.files[0];
        //     const fileSize = file.size / 1024 / 1024; // Convert to MB
        //     const validTypes = ['image/jpg', 'image/jpeg', 'image/png'];

        //     if (!validTypes.includes(file.type)) {
        //         alert('Thumbnail harus berformat JPG, JPEG, atau PNG!');
        //         return false;
        //     }

        //     if (fileSize > 5) {
        //         alert('Ukuran thumbnail maksimal 5MB!');
        //         return false;
        //     }
        // }

        // Prepare form data
        var formData = new FormData(this);

        // Show progress bar
        $('#uploadProgressContainer').show();
        $('#uploadProgressBar').css('width', '0%').attr('aria-valuenow', 0);
        $('#uploadProgressPercent').text('0%');
        $('#uploadStatus').text('Mempersiapkan upload...');

        // Disable submit button
        $(this).addClass('submitting');
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Mengunggah...');
        $(this).find('button[data-bs-dismiss="modal"]').prop('disabled', true);

        // Upload with AJAX and progress tracking
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                // Upload progress
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        $('#uploadProgressBar').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);
                        $('#uploadProgressPercent').text(percentComplete + '%');

                        if (percentComplete < 100) {
                            $('#uploadStatus').text('Mengunggah file... (' + formatBytes(evt.loaded) + ' / ' + formatBytes(evt.total) + ')');
                        } else {
                            $('#uploadStatus').text('Memproses data...');
                        }
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                $('#uploadProgressBar').removeClass('progress-bar-animated').addClass('bg-success');
                $('#uploadStatus').text('Upload berhasil! Mengalihkan...');

                // Show success message
                setTimeout(function() {
                    window.location.href = window.activityRoute;
                }, 1000);
            },
            error: function(xhr, status, error) {
                $('#uploadProgressBar').removeClass('progress-bar-animated').addClass('bg-danger');
                $('#uploadProgressPercent').text('Error!');

                var errorMsg = 'Gagal mengunggah karya!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.status === 413) {
                    errorMsg = 'File terlalu besar! Maksimal 50MB per file.';
                } else if (xhr.status === 422) {
                    errorMsg = 'Validasi gagal. Periksa kembali data yang diisi.';
                }

                $('#uploadStatus').text(errorMsg);
                alert(errorMsg);

                // Re-enable submit button
                $('#uploadKaryaForm').removeClass('submitting');
                $('#uploadKaryaForm button[type="submit"]').prop('disabled', false).html('<i class="bi bi-upload me-1"></i> Unggah Karya');
                $('#uploadKaryaForm button[data-bs-dismiss="modal"]').prop('disabled', false);

                // Hide progress bar after 3 seconds
                setTimeout(function() {
                    $('#uploadProgressContainer').hide();
                    $('#uploadProgressBar').removeClass('bg-danger').addClass('progress-bar-animated');
                }, 3000);
            }
        });

        return false;
    });

    // Helper function to format bytes
    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    // Submit edit form with Quill content and AJAX with progress bar
    $(document).on('submit', '#editKaryaForm', function(e) {
        e.preventDefault();

        // Transfer Quill content to hidden textarea
        $('#edit_description').val(editQuill.root.innerHTML);

        // Validate Quill content
        if (editQuill.getText().trim().length === 0) {
            alert('Deskripsi harus diisi!');
            return false;
        }

        // Check if file upload exists
        var fileInput = document.getElementById('edit_files');
        var hasFiles = fileInput && fileInput.files.length > 0;

        // Validate file sizes (15MB per file)
        if (hasFiles) {
            for (let i = 0; i < fileInput.files.length; i++) {
                const fileSize = fileInput.files[i].size / 1024 / 1024; // Convert to MB
                if (fileSize > 15) {
                    alert('Ukuran file "' + fileInput.files[i].name + '" melebihi 15MB!');
                    return false;
                }
            }
        }

        // Show progress bar if there are files
        if (hasFiles) {
            $('#editUploadProgressContainer').show();
            $('#editUploadProgressBar').css('width', '0%').attr('aria-valuenow', 0);
            $('#editUploadProgressPercent').text('0%');
            $('#editUploadStatus').text('Mempersiapkan upload...');
        }

        // Add loading state
        $(this).addClass('submitting');
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Menyimpan...');
        $(this).find('button[data-bs-dismiss="modal"]').prop('disabled', true);

        // Prepare form data
        var formData = new FormData(this);

        // Upload with AJAX and progress tracking
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                // Upload progress
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        $('#editUploadProgressBar').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);
                        $('#editUploadProgressPercent').text(percentComplete + '%');

                        if (percentComplete < 100) {
                            $('#editUploadStatus').text('Mengunggah file... (' + formatBytes(evt.loaded) + ' / ' + formatBytes(evt.total) + ')');
                        } else {
                            $('#editUploadStatus').text('Memproses data...');
                        }
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if (hasFiles) {
                    $('#editUploadProgressBar').removeClass('progress-bar-animated').addClass('bg-success');
                    $('#editUploadStatus').text('Berhasil disimpan! Mengalihkan...');
                }

                // Redirect after success
                setTimeout(function() {
                    window.location.href = window.activityRoute;
                }, 1000);
            },
            error: function(xhr, status, error) {
                if (hasFiles) {
                    $('#editUploadProgressBar').removeClass('progress-bar-animated').addClass('bg-danger');
                    $('#editUploadProgressPercent').text('Error!');
                }

                var errorMsg = 'Gagal menyimpan perubahan!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.status === 413) {
                    errorMsg = 'File terlalu besar! Maksimal 15MB per file.';
                } else if (xhr.status === 422) {
                    errorMsg = 'Validasi gagal. Periksa kembali data yang diisi.';
                }

                if (hasFiles) {
                    $('#editUploadStatus').text(errorMsg);
                }
                alert(errorMsg);

                // Re-enable submit button
                $('#editKaryaForm').removeClass('submitting');
                $('#editKaryaForm button[type="submit"]').prop('disabled', false).html('<i class="bi bi-save me-1"></i> Simpan Perubahan');
                $('#editKaryaForm button[data-bs-dismiss="modal"]').prop('disabled', false);

                // Hide progress bar after 3 seconds
                setTimeout(function() {
                    $('#editUploadProgressContainer').hide();
                    $('#editUploadProgressBar').removeClass('bg-danger').addClass('progress-bar-animated');
                }, 3000);
            }
        });

        return false;
    });

    // Load dropdown data when upload modal is shown
    $('#uploadKaryaModal').on('show.bs.modal', function () {
        console.log('=== UPLOAD MODAL OPENING EVENT TRIGGERED ===');

        // Initialize Quill Editor only once
        if (!quillInitialized) {
            console.log('Initializing Quill editor...');
            quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Contoh: Kebaya modern dengan bahan brokat, dipadukan dengan batik tulis khas Malang.',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }]
                    ]
                }
            });
            quillInitialized = true;
            console.log('Quill initialized successfully');
        }
    });

    // Load dropdown data when edit modal is shown
    $('#editKaryaModal').on('show.bs.modal', function () {
        console.log('=== EDIT MODAL OPENING EVENT TRIGGERED ===');

        // Initialize Quill Editor only once
        if (!editQuillInitialized) {
            console.log('Initializing Edit Quill editor...');
            editQuill = new Quill('#edit_editor', {
                theme: 'snow',
                placeholder: 'Contoh: Kebaya modern dengan bahan brokat, dipadukan dengan batik tulis khas Malang.',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }]
                    ]
                }
            });
            editQuillInitialized = true;
            console.log('Edit Quill initialized successfully');
        }
    });

    // Reset upload modal form when closed
    $('#uploadKaryaModal').on('hidden.bs.modal', function () {
        $('#uploadKaryaForm')[0].reset();
        $('#uploadKaryaForm').removeClass('submitting');
        $('#uploadKaryaForm button[type="submit"]').prop('disabled', false).html('<i class="bi bi-upload me-1"></i> Unggah Karya');
        quill.setContents([]);
        $('#jenis_karya_manual').addClass('d-none').removeAttr('required');
        // Reset kategori autocomplete
        $('#kategori_input').val('');
        $('#kategori_id').val('');
        $('#kategori_manual').val('');
        $('#kategori_suggestions').removeClass('show').html('');
        $('body').css('overflow', '');
    });

    // Reset edit modal form when closed
    $('#editKaryaModal').on('hidden.bs.modal', function () {
        $('#editKaryaForm')[0].reset();
        $('#editKaryaForm').removeClass('submitting');
        $('#editKaryaForm button[type="submit"]').prop('disabled', false).html('<i class="bi bi-save me-1"></i> Simpan Perubahan');
        $('#editKaryaForm button[data-bs-dismiss="modal"]').prop('disabled', false);
        if (editQuill) {
            editQuill.setContents([]);
        }
        $('#edit_jenis_karya_manual').addClass('d-none').removeAttr('required');
        $('#edit_kategori_manual').addClass('d-none').removeAttr('required');
        // Reset progress bar
        $('#editUploadProgressContainer').hide();
        $('#editUploadProgressBar').css('width', '0%').removeClass('bg-success bg-danger').addClass('progress-bar-animated');
        $('#editUploadProgressPercent').text('0%');
        $('#editUploadStatus').text('');
        $('body').css('overflow', '');
    });

    // Prevent body scroll when modal is open - for better mobile experience
    $('#uploadKaryaModal, #editKaryaModal, #detailKaryaModal').on('shown.bs.modal', function () {
        $('body').css('overflow', 'hidden');
    });

    // Restore body scroll when modal is closed
    $('#uploadKaryaModal, #editKaryaModal, #detailKaryaModal').on('hidden.bs.modal', function () {
        $('body').css('overflow', '');
    });
});
