<?php

namespace App\Http\Controllers;

use App\Models\JenisKarya;
use App\Models\Karya;
use App\Models\KaryaFile;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Language;
use App\Mail\KaryaWaitingVerification;
use App\Mail\KaryaStatusChanged;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KaryaController extends Controller
{

    public function showDetail($id, $nim, $slug)
    {
        $karya = Karya::with(['files', 'jenisKarya', 'kategori', 'user.jurusan', 'language', 'pembimbing'])
            ->where('id', $id)
            ->whereHas('user', function($q) use ($nim) {
                $q->where('nim', $nim);
            })
            ->where('status', 'Terpublish')
            ->where('rights', 'Semua')
            ->firstOrFail();

        $user = Auth::user();

        return view('detail-jelajahi', compact('karya', 'user'));
    }

    public function show($id)
    {
        $karya = Karya::with(['files', 'jenisKarya', 'kategori', 'user', 'language', 'pembimbing'])->findOrFail($id);

        // If AJAX request, return JSON
        if (request()->ajax()) {
            return response()->json($karya);
        }

        return view('karya.index', compact('karya'));
    }

    public function edit($id)
    {
        $karya = Karya::with(['files', 'jenisKarya', 'kategori', 'language'])->findOrFail($id);

        // If AJAX request, return JSON
        if (request()->ajax()) {
            return response()->json($karya);
        }

        return view('karya.edit', compact('karya'));
    }

    public function update($id, Request $request)
    {
        $karya = Karya::with('files')->findOrFail($id);

        // Validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'source' => 'nullable|string|max:255',
            'date' => 'required|date',
            'pembimbing_id' => 'required|exists:users,id',
            'rights' => 'required|in:Semua,Terbatas',
            'relation' => 'nullable|string|max:255',
            'language_id' => 'required|exists:languages,id',
            'coverage' => 'nullable|string|max:255',
            // 'files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,ppt,pptx,mp4|max:15360', // 15MB
            'edit_files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,ppt,pptx,mp4|max:15360', // 15MB
        ];

        // Conditional validation for jenis_karya
        if ($request->input('jenis_karya_id') === 'manual_input') {
            $rules['jenis_karya_manual'] = 'required|string|max:255';
        } else {
            $rules['jenis_karya_id'] = 'required|exists:jenis_karyas,id';
        }

        // Conditional validation for kategori
        if ($request->input('kategori_id') === 'manual_input') {
            $rules['kategori_manual'] = 'required|string|max:255';
        } else {
            $rules['kategori_id'] = 'required|exists:kategoris,id';
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            // Handle Jenis Karya - with race condition protection
            if ($request->input('jenis_karya_id') === 'manual_input') {
                $jenisKaryaNama = ucwords(strtolower($request->input('jenis_karya_manual')));
                $jenisKarya = JenisKarya::firstOrCreate(['nama' => $jenisKaryaNama]);
                $jenisKaryaId = $jenisKarya->id;
            } else {
                $jenisKaryaId = $request->input('jenis_karya_id');
            }

            // Handle Kategori - with race condition protection
            if ($request->input('kategori_id') === 'manual_input') {
                $kategoriNama = ucwords(strtolower($request->input('kategori_manual')));
                $kategori = Kategori::firstOrCreate(['nama' => $kategoriNama]);
                $kategoriId = $kategori->id;
            } else {
                $kategoriId = $request->input('kategori_id');
            }

            // Update data utama karya
            $karya->update([
                'jenis_karya_id' => $jenisKaryaId,
                'title' => $validated['title'],
                'kategori_id' => $kategoriId,
                'description' => $validated['description'],
                'source' => $validated['source'],
                'date' => $validated['date'],
                'pembimbing_id' => $validated['pembimbing_id'],
                'rights' => $validated['rights'],
                'relation' => $validated['relation'],
                'language_id' => $validated['language_id'],
                'coverage' => $validated['coverage'],
            ]);

            // Jika ada file baru (dari 'files' atau 'edit_files'), hapus file lama dan upload yang baru
            $uploadedFiles = $request->hasFile('files') ? $request->file('files') : ($request->hasFile('edit_files') ? $request->file('edit_files') : null);

            if ($uploadedFiles) {
                // Hapus semua file lama dari storage
                foreach ($karya->files as $oldFile) {
                    if (Storage::disk('public')->exists($oldFile->file_path)) {
                        Storage::disk('public')->delete($oldFile->file_path);
                    }

                    // Hapus thumbnail lama jika ada
                    if ($oldFile->thumbnail && Storage::disk('public')->exists($oldFile->thumbnail)) {
                        Storage::disk('public')->delete($oldFile->thumbnail);
                    }

                    // Hapus record dari database
                    $oldFile->delete();
                }

                // Get user's angkatan and jurusan for folder structure
                $user = User::with('jurusan')->findOrFail($karya->user_id);
                $angkatan = $user->angkatan ?? 'Umum';
                $jurusanNama = $user->jurusan->nama ?? 'Umum';
                $folderPath = "uploads/{$angkatan}/{$jurusanNama}";

                // Upload file baru
                foreach ($uploadedFiles as $file) {
                    $path = $file->store($folderPath, 'public');

                    $karya->files()->create([
                        'file_path' => $path,
                        'format' => $file->getClientOriginalExtension(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            // Jika ada thumbnail baru, update thumbnail pada file pertama
            // if ($request->hasFile('thumbnail')) {
            //     $firstFile = $karya->files()->first();

            //     if ($firstFile) {
            //         // Hapus thumbnail lama jika ada
            //         if ($firstFile->thumbnail && Storage::disk('public')->exists($firstFile->thumbnail)) {
            //             Storage::disk('public')->delete($firstFile->thumbnail);
            //         }

            //         // Get user's kelas and jurusan for folder structure
            //         $user = User::with('jurusan')->findOrFail($karya->user_id);
            //         $kelas = $user->kelas ?? 'Umum';
            //         $jurusanNama = $user->jurusan->nama ?? 'Umum';
            //         $folderPath = "uploads/{$kelas}/{$jurusanNama}/thumbnails";

            //         // Upload thumbnail baru
            //         $thumbnailPath = $request->file('thumbnail')->store($folderPath, 'public');
            //         $firstFile->update(['thumbnail' => $thumbnailPath]);
            //     }
            // }

            DB::commit();

            return redirect()->back()->with('success', 'Manuskrip berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui manuskrip: ' . $e->getMessage());
        }
    }

    // Get Jenis Karya for dropdown
    public function getJenisKarya()
    {
        try {
            $jenisKaryas = JenisKarya::all()->sortBy('nama');
            Log::info('Jenis Karya fetched: ' . $jenisKaryas->count() . ' items');
            return response()->json($jenisKaryas);
        } catch (\Exception $e) {
            Log::error('Error fetching Jenis Karya: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    // Get Kategori for dropdown
    public function getKategori()
    {
        try {
            $kategoris = Kategori::all()->sortBy('nama');
            Log::info('Kategori fetched: ' . $kategoris->count() . ' items');
            return response()->json($kategoris);
        } catch (\Exception $e) {
            Log::error('Error fetching Kategori: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    // Get Pembimbing (Admin users) for dropdown
    public function getPembimbing()
    {
        try {
            $admins = User::where('role', 'admin')->orderBy('name', 'asc')->get();
            Log::info('Pembimbing fetched: ' . $admins->count() . ' items');
            return response()->json($admins);
        } catch (\Exception $e) {
            Log::error('Error fetching Pembimbing: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    // Get Languages for dropdown
    public function getLanguages()
    {
        try {
            $languages = Language::all()->sortBy('nama');
            Log::info('Languages fetched: ' . $languages->count() . ' items');
            return response()->json($languages);
        } catch (\Exception $e) {
            Log::error('Error fetching Languages: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    // Store Karya from Activity page with race condition handling
    public function storeFromActivity(Request $request)
    {
        // Validation rules
        $rules = [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'source' => 'required|string|max:255',
            'date' => 'required|date',
            'pembimbing_id' => 'required|exists:users,id',
            'rights' => 'required|in:Semua,Terbatas',
            'relation' => 'required|string|max:255',
            'language_id' => 'required|exists:languages,id',
            'coverage' => 'required|string|max:255',
            'files.*' => 'required|file|max:15360|mimes:pdf,jpg,jpeg,png,ppt,pptx,mp4',
        ];

        // Conditional validation for jenis_karya
        if ($request->input('jenis_karya_id') === 'manual_input') {
            $rules['jenis_karya_manual'] = 'required|string|max:255';
        } else {
            $rules['jenis_karya_id'] = 'required|exists:jenis_karyas,id';
        }

        // Conditional validation for kategori
        if ($request->input('kategori_id') === 'manual_input') {
            $rules['kategori_manual'] = 'required|string|max:255';
        } else {
            $rules['kategori_id'] = 'required|exists:kategoris,id';
        }

        // Custom validation messages
        $messages = [
            'files.*.max' => 'Ukuran file tidak boleh melebihi 15MB.',
            'files.*.mimes' => 'Format file harus: PDF, JPG, PNG, PPT, atau MP4.',
            'files.*.required' => 'File manuskrip harus diunggah.',
        ];

        $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            // Handle Jenis Karya - with race condition protection
            if ($request->input('jenis_karya_id') === 'manual_input') {
                $jenisKaryaNama = ucwords(strtolower($request->input('jenis_karya_manual')));

                // Use firstOrCreate to handle race condition
                $jenisKarya = JenisKarya::firstOrCreate(
                    ['nama' => $jenisKaryaNama]
                );
                $jenisKaryaId = $jenisKarya->id;
            } else {
                $jenisKaryaId = $request->input('jenis_karya_id');
            }

            // Handle Kategori - with race condition protection
            if ($request->input('kategori_id') === 'manual_input') {
                $kategoriNama = ucwords(strtolower($request->input('kategori_manual')));

                // Use firstOrCreate to handle race condition
                $kategori = Kategori::firstOrCreate(
                    ['nama' => $kategoriNama]
                );
                $kategoriId = $kategori->id;
            } else {
                $kategoriId = $request->input('kategori_id');
            }

            // Create Karya record
            $karya = Karya::create([
                'user_id' => $request->input('user_id'),
                'jenis_karya_id' => $jenisKaryaId,
                'title' => $request->input('title'),
                'kategori_id' => $kategoriId,
                'description' => $request->input('description'),
                'source' => $request->input('source'),
                'date' => $request->input('date'),
                'pembimbing_id' => $request->input('pembimbing_id'),
                'rights' => $request->input('rights'),
                'relation' => $request->input('relation'),
                'language_id' => $request->input('language_id'),
                'coverage' => $request->input('coverage'),
                'status' => 'Menunggu',
            ]);

            // Get user's angkatan and jurusan for folder structure
            $user = User::with('jurusan')->findOrFail($request->input('user_id'));
            $angkatan = $user->angkatan ?? 'Umum';
            $jurusanNama = $user->jurusan->nama ?? 'Umum';

            // Define folder path based on angkatan and jurusan
            $folderPath = "uploads/{$angkatan}/{$jurusanNama}";

            // // Handle thumbnail upload
            // $thumbnailPath = null;
            // if ($request->hasFile('thumbnail')) {
            //     $thumbnailFile = $request->file('thumbnail');
            //     $thumbnailPath = $thumbnailFile->store("{$folderPath}/thumbnails", 'public');
            // }

            // Handle file uploads
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    // Store file in the specific folder structure
                    $filePath = $file->store($folderPath, 'public');

                    // Get file extension/format
                    $format = $file->getClientOriginalExtension();

                    // Get file size
                    $size = $file->getSize();

                    // Create KaryaFile record
                    KaryaFile::create([
                        'karya_id' => $karya->id,
                        'file_path' => $filePath,
                        'format' => $format,
                        'size' => $size,
                        'thumbnail' => null,
                    ]);
                }
            }

            // Create single notification for karya baru
            $user = User::find($request->input('user_id'));
            DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\\Notifications\\KaryaBaruNotification',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id' => 0, // 0 untuk semua admin/superadmin
                'data' => json_encode([
                    'karya_id' => $karya->id,
                    'admin_id' => null,
                    'title' => $karya->title,
                    'user_id' => $request->input('user_id'),
                    'jurusan_id' => $user ? $user->jurusan_id : null,
                    'type' => 'karya_new'
                ]),
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Kirim email ke user yang sedang login
            try {
                $jenisKaryaNama = JenisKarya::find($jenisKaryaId)->nama ?? 'Tidak diketahui';
                $subjekNama = Kategori::find($kategoriId)->nama ?? 'Tidak diketahui';
                // ubah uploadDate untuk menggunakan value "date" dari request
                $uploadDate = $request->input('date');
                $activityUrl = route('activity');

                Mail::to($user->email)->send(
                    new KaryaWaitingVerification(
                        $user->name,
                        $karya->title,
                        $jenisKaryaNama,
                        $subjekNama,
                        $uploadDate,
                        $activityUrl
                    )
                );

                Log::info('Email sent successfully to: ' . $user->email);
            } catch (\Exception $emailException) {
                // Log error tapi tidak menghentikan proses
                Log::error('Failed to send email: ' . $emailException->getMessage());
            }

            DB::commit();

            // Return JSON response for AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Manuskrip berhasil diunggah dan sedang menunggu persetujuan.',
                    'redirect' => route('activity')
                ], 200);
            }

            return redirect()->route('activity')->with('success', 'Manuskrip berhasil diunggah dan sedang menunggu persetujuan.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Return JSON response for AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengunggah manuskrip: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengunggah manuskrip: ' . $e->getMessage());
        }
    }

    // Superadmin Methods
    public function indexSuperadmin(Request $request)
    {
        $query = Karya::with(['user', 'jenisKarya', 'kategori', 'language', 'pembimbing']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'date');
        $sortOrder = $request->get('sort_order', 'desc');

        // Handle sorting by related tables
        if ($sortBy === 'user_id') {
            $query->join('users', 'karyas.user_id', '=', 'users.id')
                  ->select('karyas.*')
                  ->orderBy('users.name', $sortOrder);
        } elseif ($sortBy === 'jenis_karya_id') {
            $query->join('jenis_karyas', 'karyas.jenis_karya_id', '=', 'jenis_karyas.id')
                  ->select('karyas.*')
                  ->orderBy('jenis_karyas.nama', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Statistics
        $totalKarya = Karya::count();
        $karyaTerpublish = Karya::where('status', 'Terpublish')->count();
        $karyaMenunggu = Karya::where('status', 'Menunggu')->count();
        $karyaDitolak = Karya::where('status', 'Ditolak')->count();
        $karyaDiarsipkan = Karya::where('status', 'Arsip')->count();

        // Get Jenis Karya data
        $jenisKaryas = JenisKarya::withCount('karyas')->orderBy('nama', 'asc')->paginate(10);

        // Get available years from karyas
        $availableYears = Karya::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Pagination
        $karyas = $query->paginate(25)->appends($request->all());

        return view('superadmin.karya.index', compact('karyas', 'totalKarya', 'karyaTerpublish', 'karyaMenunggu', 'karyaDitolak', 'karyaDiarsipkan', 'jenisKaryas', 'availableYears'));
    }

    public function showSuperadmin($id)
    {
        $karya = Karya::with(['user.jurusan', 'jenisKarya', 'kategori', 'language', 'pembimbing', 'files'])->findOrFail($id);
        return response()->json($karya);
    }

    public function updateSuperadmin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Terpublish,Ditolak,Arsip',
            'keterangan' => 'nullable|string'
        ]);

        $karya = Karya::with(['user', 'jenisKarya', 'kategori'])->findOrFail($id);
        $oldStatus = $karya->status;
        $newStatus = $request->status;

        $karya->update([
            'status' => $newStatus,
            'keterangan' => $request->keterangan
        ]);

        // Create notification when status changes from Menunggu to Terpublish
        if ($oldStatus === 'Menunggu' && $newStatus === 'Terpublish') {
            $adminId = Auth::id();

            // Create single notification for karya published
            DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\\Notifications\\KaryaBaruNotification',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id' => 0, // 0 untuk semua admin/superadmin
                'data' => json_encode([
                    'karya_id' => $karya->id,
                    'admin_id' => $adminId,
                    'title' => $karya->title,
                    'jurusan_id' => $karya->user ? $karya->user->jurusan_id : null,
                    'type' => 'karya_published'
                ]),
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Kirim email ke user pemilik karya jika status berubah ke Terpublish, Ditolak, atau Arsip
        if ($oldStatus !== $newStatus && in_array($newStatus, ['Terpublish', 'Ditolak', 'Arsip'])) {
            try {
                $user = $karya->user;

                if ($user && $user->email) {
                    $jenisKaryaNama = $karya->jenisKarya->nama ?? 'Tidak diketahui';
                    $subjekNama = $karya->kategori->nama ?? 'Tidak diketahui';
                    $updateDate = now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm');
                    $activityUrl = route('activity');

                    Mail::to($user->email)->send(
                        new KaryaStatusChanged(
                            $user->name,
                            $karya->title,
                            $jenisKaryaNama,
                            $subjekNama,
                            $newStatus,
                            $request->keterangan ?? '',
                            $updateDate,
                            $activityUrl
                        )
                    );

                    Log::info("Karya status changed email sent to: {$user->email} - Status: {$newStatus}");
                }
            } catch (\Exception $emailException) {
                // Log error tapi tidak menghentikan proses
                Log::error('Failed to send karya status changed email: ' . $emailException->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Manuskrip berhasil diperbarui'
        ]);
    }

    public function destroySuperadmin($id)
    {
        $karya = Karya::findOrFail($id);

        // Delete associated files from storage
        foreach ($karya->files as $file) {
            if ($file->file_path && Storage::exists('public/' . $file->file_path)) {
                Storage::delete('public/' . $file->file_path);
            }
            if ($file->thumbnail && Storage::exists('public/' . $file->thumbnail)) {
                Storage::delete('public/' . $file->thumbnail);
            }
        }

        $karya->delete();

        return response()->json([
            'success' => true,
            'message' => 'Manuskrip berhasil dihapus'
        ]);
    }

    public function exportExcel(Request $request)
    {
        $year = $request->input('year');
        $currentUser = auth()->user();

        if (!$year) {
            return redirect()->back()->with('error', 'Tahun harus dipilih');
        }

        // Get all jurusans (filter by admin's jurusan if admin)
        if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
            $allJurusans = \App\Models\Jurusan::where('id', $currentUser->jurusan_id)
                ->orderBy('nama', 'asc')->get();
        } else {
            $allJurusans = \App\Models\Jurusan::orderBy('nama', 'asc')->get();
        }

        // Get all karyas with status Terpublish for the selected year
        $karyasQuery = Karya::with(['user.jurusan', 'user.prodi', 'jenisKarya', 'pembimbing', 'language'])
            ->where('status', 'Terpublish')
            ->whereYear('date', $year)
            ->join('users', 'karyas.user_id', '=', 'users.id')
            ->select('karyas.*');

        // Filter by admin's jurusan if admin
        if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
            $karyasQuery->where('users.jurusan_id', $currentUser->jurusan_id);
        }

        $karyas = $karyasQuery->orderBy('users.jurusan_id')
            ->orderBy('karyas.date', 'desc')
            ->get();

        // Group karyas by jurusan
        $karyasByJurusan = $karyas->groupBy(function($karya) {
            return $karya->user->jurusan->id ?? 0;
        });

        // Create new Spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->removeSheetByIndex(0); // Remove default sheet

        $sheetIndex = 0;

        // Loop through all jurusans
        foreach ($allJurusans as $jurusan) {
            $jurusanId = $jurusan->id;
            $jurusanNama = $jurusan->nama;
            $karyasInJurusan = $karyasByJurusan->get($jurusanId, collect());

            // Create new sheet
            $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $jurusanNama);
            $spreadsheet->addSheet($sheet, $sheetIndex);

            // Set active sheet
            $spreadsheet->setActiveSheetIndex($sheetIndex);
            $activeSheet = $spreadsheet->getActiveSheet();

            // Set column headers
            $headers = ['No', 'Nama Mahasiswa', 'NIM', 'Program Studi', 'Judul', 'Jenis Manuskrip', 'Tanggal Unggah', 'Pembimbing', 'Bahasa', 'Status'];
            $column = 'A';
            foreach ($headers as $header) {
                $activeSheet->setCellValue($column . '1', $header);
                $activeSheet->getStyle($column . '1')->getFont()->setBold(true);
                $activeSheet->getStyle($column . '1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFD3D3D3');
                $column++;
            }

            // Auto width for columns
            foreach (range('A', 'J') as $col) {
                $activeSheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Fill data if exists
            $row = 2;
            $no = 1;
            foreach ($karyasInJurusan as $karya) {
                $activeSheet->setCellValue('A' . $row, $no++);
                $activeSheet->setCellValue('B' . $row, $karya->user->name ?? '-');
                // Set NIM as string explicitly
                $activeSheet->setCellValueExplicit(
                    'C' . $row,
                    $karya->user->nim ?? '-',
                    \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
                );
                $activeSheet->setCellValue('D' . $row, $karya->user->prodi->nama ?? '-');
                $activeSheet->setCellValue('E' . $row, $karya->title);
                $activeSheet->setCellValue('F' . $row, $karya->jenisKarya->nama ?? '-');
                $activeSheet->setCellValue('G' . $row, \Carbon\Carbon::parse($karya->date)->format('d/m/Y'));
                $activeSheet->setCellValue('H' . $row, $karya->pembimbing->name ?? '-');
                $activeSheet->setCellValue('I' . $row, $karya->language->nama ?? '-');
                $activeSheet->setCellValue('J' . $row, $karya->status);
                $row++;
            }

            // Add borders to all cells with data (including header)
            $lastRow = $row > 2 ? $row - 1 : 1;
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
            $activeSheet->getStyle('A1:J' . $lastRow)->applyFromArray($styleArray);

            $sheetIndex++;
        }

        // Set first sheet as active
        if ($spreadsheet->getSheetCount() > 0) {
            $spreadsheet->setActiveSheetIndex(0);
        }

        // Create writer and download
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Laporan_Manuskrip_' . $year . '_' . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    // Admin methods
    public function indexAdmin(Request $request)
    {
        $currentUser = auth()->user();

        $query = Karya::with(['user', 'jenisKarya', 'kategori', 'language', 'pembimbing']);

        // Filter by admin's jurusan_id through user relationship
        if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
            $query->whereHas('user', function($q) use ($currentUser) {
                $q->where('jurusan_id', $currentUser->jurusan_id);
            });
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'date');
        $sortOrder = $request->get('sort_order', 'desc');

        // Handle sorting by related tables
        if ($sortBy === 'user_id') {
            $query->join('users', 'karyas.user_id', '=', 'users.id')
                  ->select('karyas.*')
                  ->orderBy('users.name', $sortOrder);
        } elseif ($sortBy === 'jenis_karya_id') {
            $query->join('jenis_karyas', 'karyas.jenis_karya_id', '=', 'jenis_karyas.id')
                  ->select('karyas.*')
                  ->orderBy('jenis_karyas.nama', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Statistics - filtered by admin's jurusan
        $totalKarya = Karya::whereHas('user', function($q) use ($currentUser) {
            if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
                $q->where('jurusan_id', $currentUser->jurusan_id);
            }
        })->count();

        $karyaTerpublish = Karya::where('status', 'Terpublish')
            ->whereHas('user', function($q) use ($currentUser) {
                if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
                    $q->where('jurusan_id', $currentUser->jurusan_id);
                }
            })->count();

        $karyaMenunggu = Karya::where('status', 'Menunggu')
            ->whereHas('user', function($q) use ($currentUser) {
                if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
                    $q->where('jurusan_id', $currentUser->jurusan_id);
                }
            })->count();

        $karyaDitolak = Karya::where('status', 'Ditolak')
            ->whereHas('user', function($q) use ($currentUser) {
                if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
                    $q->where('jurusan_id', $currentUser->jurusan_id);
                }
            })->count();

        $karyaDiarsipkan = Karya::where('status', 'Arsip')
            ->whereHas('user', function($q) use ($currentUser) {
                if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
                    $q->where('jurusan_id', $currentUser->jurusan_id);
                }
            })->count();

        // Get Jenis Karya data
        $jenisKaryas = JenisKarya::withCount('karyas')->orderBy('nama', 'asc')->paginate(10);

        // Get available years for filter
        $availableYears = Karya::whereHas('user', function($q) use ($currentUser) {
            if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
                $q->where('jurusan_id', $currentUser->jurusan_id);
            }
        })
        ->selectRaw('YEAR(date) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

        // Pagination
        $karyas = $query->paginate(25)->appends($request->all());

        return view('superadmin.karya.index', compact(
            'karyas',
            'totalKarya',
            'karyaTerpublish',
            'karyaMenunggu',
            'karyaDitolak',
            'karyaDiarsipkan',
            'jenisKaryas',
            'availableYears'
        ));
    }

    public function showAdmin($id)
    {
        $currentUser = auth()->user();

        $karya = Karya::with(['user', 'jenisKarya', 'kategori', 'language', 'pembimbing', 'files'])->findOrFail($id);

        // Verify admin can only access karyas from their jurusan
        if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
            if ($karya->user->jurusan_id !== $currentUser->jurusan_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        return response()->json($karya);
    }

    public function updateAdmin(Request $request, $id)
    {
        $currentUser = auth()->user();

        $karya = Karya::with('user')->findOrFail($id);

        // Verify admin can only update karyas from their jurusan
        if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
            if ($karya->user->jurusan_id !== $currentUser->jurusan_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        }

        return $this->updateSuperadmin($request, $id);
    }

    public function destroyAdmin($id)
    {
        $currentUser = auth()->user();

        $karya = Karya::with('user')->findOrFail($id);

        // Verify admin can only delete karyas from their jurusan
        if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
            if ($karya->user->jurusan_id !== $currentUser->jurusan_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        }

        return $this->destroySuperadmin($id);
    }

    /**
     * Download file manuskrip
     */
    public function downloadFile($fileId)
    {
        // Try to find by ID first, then by filename
        $file = KaryaFile::where('id', $fileId)
            ->orWhereRaw('SUBSTRING_INDEX(file_path, "/", -1) = ?', [$fileId])
            ->firstOrFail();

        // Check if file exists
        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Get file extension
        $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));

        // List of extensions that can be viewed in browser
        $viewableExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm', 'txt', 'svg'];

        // Get full path to file
        $fullPath = storage_path('app/public/' . $file->file_path);

        // Get file content
        $fileContent = Storage::disk('public')->get($file->file_path);

        // Determine mime type based on extension
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'txt' => 'text/plain',
            'svg' => 'image/svg+xml',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];

        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';

        // If file can be viewed in browser, display inline
        if (in_array($extension, $viewableExtensions)) {
            return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . basename($file->file_path) . '"');
        }

        // Otherwise, force download
        return response()->download($fullPath, basename($file->file_path));
    }

    /**
     * View/Stream file manuskrip (for preview in browser)
     */
    public function viewFile($fileId)
    {
        $file = KaryaFile::findOrFail($fileId);

        // Check if file exists
        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Get file content and mime type
        $fileContent = Storage::disk('public')->get($file->file_path);
        $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);

        // Determine mime type based on extension
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];

        $mimeType = $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . basename($file->file_path) . '"');
    }

    /**
     * Get thumbnail image
     */
    public function getThumbnail($fileId)
    {
        $file = KaryaFile::findOrFail($fileId);

        if (!$file->thumbnail || !Storage::disk('public')->exists($file->thumbnail)) {
            abort(404, 'Thumbnail tidak ditemukan');
        }

        $thumbnailContent = Storage::disk('public')->get($file->thumbnail);
        $extension = pathinfo($file->thumbnail, PATHINFO_EXTENSION);

        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];

        $mimeType = $mimeTypes[strtolower($extension)] ?? 'image/jpeg';

        return response($thumbnailContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Cache-Control', 'public, max-age=31536000');
    }
}
