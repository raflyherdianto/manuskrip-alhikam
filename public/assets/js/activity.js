/**
 * Activity Dashboard JavaScript
 * Handles sidebar toggle, chart rendering, and responsive behavior
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {

    // ============================================
    // SIDEBAR TOGGLE FUNCTIONALITY
    // ============================================

    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('activitySidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarClose = document.getElementById('sidebarClose');

    // Open sidebar
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent body scroll when sidebar is open
        });
    }

    // Close sidebar
    function closeSidebar() {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = ''; // Restore body scroll
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    // Close sidebar on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
            closeSidebar();
        }
    });


    // ============================================
    // CHART.JS INITIALIZATION
    // ============================================

    const chartCanvas = document.getElementById('chartTahunan');
    let yearlyChart = null;

    if (chartCanvas) {
        const ctx = chartCanvas.getContext('2d');
        const currentYear = new Date().getFullYear();

        // Initialize chart with monthly data
        function initializeChart(year) {
            // Fetch monthly data for the selected year
            fetch(`/activity/monthly-stats?year=${year}`)
                .then(response => response.json())
                .then(data => {
                    const chartData = {
                        labels: data.months,
                        datasets: [{
                            label: `Jumlah Karya Tahun ${data.year}`,
                            data: data.totals,
                            backgroundColor: '#1F304B',
                            borderColor: '#1F304B',
                            borderWidth: 1,
                            borderRadius: 4,
                            hoverBackgroundColor: '#2d4363'
                        }]
                    };

                    const chartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14,
                                        family: "'Instrument Sans', sans-serif"
                                    },
                                    padding: 15
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(31, 48, 75, 0.9)',
                                titleFont: {
                                    size: 14,
                                    family: "'Instrument Sans', sans-serif"
                                },
                                bodyFont: {
                                    size: 13,
                                    family: "'Instrument Sans', sans-serif"
                                },
                                padding: 12,
                                cornerRadius: 4,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Total: ' + context.parsed.y + ' karya';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 12,
                                        family: "'Instrument Sans', sans-serif"
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Karya',
                                    font: {
                                        size: 13,
                                        weight: '600',
                                        family: "'Instrument Sans', sans-serif"
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 12,
                                        family: "'Instrument Sans', sans-serif"
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Bulan',
                                    font: {
                                        size: 13,
                                        weight: '600',
                                        family: "'Instrument Sans', sans-serif"
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    };

                    // Destroy existing chart if it exists
                    if (yearlyChart) {
                        yearlyChart.destroy();
                    }

                    // Create new chart
                    yearlyChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: chartOptions
                    });
                })
                .catch(error => {
                    console.error('Error loading chart data:', error);
                });
        }

        // Initialize with current year
        initializeChart(currentYear);

        // Year filter change handler
        const yearFilter = document.getElementById('yearFilter');
        if (yearFilter) {
            yearFilter.addEventListener('change', function() {
                initializeChart(this.value);
            });
        }

        // Handle responsive chart updates
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (yearlyChart) {
                    yearlyChart.resize();
                }
            }, 250);
        });
    }


    // ============================================
    // YEARLY HISTORY MODAL
    // ============================================

    const tahunIniCard = document.getElementById('tahunIniCard');
    const yearlyHistoryModal = document.getElementById('yearlyHistoryModal');
    const closeYearlyModal = document.getElementById('closeYearlyModal');
    const yearlyHistoryContent = document.getElementById('yearlyHistoryContent');

    // Open modal and load history
    if (tahunIniCard) {
        tahunIniCard.addEventListener('click', function() {
            yearlyHistoryModal.classList.add('active');
            document.body.style.overflow = 'hidden';
            loadYearlyHistory();
        });
    }

    // Close modal
    function closeYearlyHistoryModal() {
        if (yearlyHistoryModal) {
            yearlyHistoryModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    if (closeYearlyModal) {
        closeYearlyModal.addEventListener('click', closeYearlyHistoryModal);
    }

    // Close modal when clicking outside
    if (yearlyHistoryModal) {
        yearlyHistoryModal.addEventListener('click', function(e) {
            if (e.target === yearlyHistoryModal) {
                closeYearlyHistoryModal();
            }
        });
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && yearlyHistoryModal && yearlyHistoryModal.classList.contains('active')) {
            closeYearlyHistoryModal();
        }
    });

    // Load yearly history data
    function loadYearlyHistory() {
        yearlyHistoryContent.innerHTML = `
            <div class="loading-spinner">
                <i class="bi bi-arrow-clockwise spin"></i>
                <span>Memuat data...</span>
            </div>
        `;

        fetch('/activity/yearly-history')
            .then(response => response.json())
            .then(data => {
                if (data.history && data.history.length > 0) {
                    let historyHTML = '<div class="yearly-history-list">';

                    data.history.forEach(item => {
                        historyHTML += `
                            <div class="history-item">
                                <div class="history-year">
                                    <i class="bi bi-calendar3"></i>
                                    <span>Tahun ${item.year}</span>
                                </div>
                                <div class="history-count">
                                    <span class="count-value">${item.total}</span>
                                    <span class="count-label">karya</span>
                                </div>
                            </div>
                        `;
                    });

                    historyHTML += '</div>';
                    yearlyHistoryContent.innerHTML = historyHTML;
                } else {
                    yearlyHistoryContent.innerHTML = `
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada riwayat karya</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading yearly history:', error);
                yearlyHistoryContent.innerHTML = `
                    <div class="error-state">
                        <i class="bi bi-exclamation-triangle"></i>
                        <p>Gagal memuat data</p>
                    </div>
                `;
            });
    }


    // ============================================
    // RESPONSIVE SIDEBAR BEHAVIOR
    // ============================================

    function handleResponsiveSidebar() {
        const isDesktop = window.innerWidth >= 768;

        if (isDesktop) {
            // On desktop, always show sidebar and remove overlay
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Initial check
    handleResponsiveSidebar();

    // Check on window resize
    let resizeSidebarTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeSidebarTimer);
        resizeSidebarTimer = setTimeout(handleResponsiveSidebar, 100);
    });


    // ============================================
    // ACTIVE NAV LINK HIGHLIGHTING
    // ============================================

    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        const linkPath = new URL(link.href).pathname;

        if (linkPath === currentPath) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });


    // ============================================
    // SMOOTH SCROLL TO TOP
    // ============================================

    window.addEventListener('load', function() {
        window.scrollTo(0, 0);
    });


    // ============================================
    // TOAST AUTO HIDE (if exists)
    // ============================================

    const toastElement = document.querySelector('.toast');
    if (toastElement) {
        setTimeout(function() {
            const toast = new bootstrap.Toast(toastElement);
            toast.hide();
        }, 5000);
    }


    // ============================================
    // EDIT PROFILE MODAL FUNCTIONALITY
    // ============================================

    const btnEditProfile = document.getElementById('btnEditProfile');
    const editProfileModal = document.getElementById('editProfileModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const cancelEditModal = document.getElementById('cancelEditModal');

    // Open modal
    if (btnEditProfile) {
        btnEditProfile.addEventListener('click', function() {
            editProfileModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    // Close modal function
    function closeModal() {
        if (editProfileModal) {
            editProfileModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Close modal on X button
    if (closeEditModal) {
        closeEditModal.addEventListener('click', closeModal);
    }

    // Close modal on Cancel button
    if (cancelEditModal) {
        cancelEditModal.addEventListener('click', closeModal);
    }

    // Close modal when clicking outside
    if (editProfileModal) {
        editProfileModal.addEventListener('click', function(e) {
            if (e.target === editProfileModal) {
                closeModal();
            }
        });
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && editProfileModal && editProfileModal.classList.contains('active')) {
            closeModal();
        }
    });

});


// ============================================
// UTILITY FUNCTIONS
// ============================================

/**
 * Format number with thousand separators
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/**
 * Get user initials from name
 */
function getUserInitials(name) {
    if (!name) return '?';

    const parts = name.trim().split(' ');
    if (parts.length === 1) {
        return parts[0].charAt(0).toUpperCase();
    }

    return (parts[0].charAt(0) + parts[parts.length - 1].charAt(0)).toUpperCase();
}

/**
 * Truncate text with ellipsis
 */
function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;
    return text.substr(0, maxLength) + '...';
}
