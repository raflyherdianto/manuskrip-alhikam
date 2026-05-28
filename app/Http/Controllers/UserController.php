<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = auth()->user();

        // Query for Dosen (admin role)
        $queryDosen = User::with('jurusan')->where('role', 'admin');

        // Query for Mahasiswa (user role)
        $queryMahasiswa = User::with('jurusan')->where('role', 'user');

        // If current user is admin (role = 'admin'), filter mahasiswa by jurusan_id
        if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
            $queryMahasiswa->where('jurusan_id', $currentUser->jurusan_id);
        }

        // Search for Dosen
        if ($request->has('search_dosen') && $request->search_dosen != '') {
            $search = $request->search_dosen;
            $queryDosen->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%');
            });
        }

        // Search for Mahasiswa
        if ($request->has('search_mahasiswa') && $request->search_mahasiswa != '') {
            $search = $request->search_mahasiswa;
            $queryMahasiswa->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('nim', 'like', '%' . $search . '%');
            });
        }

        // Statistics
        $totalUsers = User::count();
        $userMahasiswa = User::where('role', 'user');

        // If current user is admin, filter count by jurusan_id
        if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
            $userMahasiswa->where('jurusan_id', $currentUser->jurusan_id);
        }

        $userMahasiswa = $userMahasiswa->count();
        $userDosen = User::where('role', 'admin')->count();
        $userSuperadmin = User::where('role', 'superadmin')->count();

        // Additional statistics for admin role
        $userLakiLaki = 0;
        $userPerempuan = 0;
        $userBelumVerified = 0;
        $userAngkatan2021 = 0;
        $userAngkatan2022 = 0;
        $userAngkatan2023 = 0;
        $userAngkatan2024 = 0;

        if ($currentUser->role === 'admin' && $currentUser->jurusan_id) {
            $userLakiLaki = User::where('role', 'user')
                ->where('jurusan_id', $currentUser->jurusan_id)
                ->where('jenis_kelamin', 'L')
                ->count();

            $userPerempuan = User::where('role', 'user')
                ->where('jurusan_id', $currentUser->jurusan_id)
                ->where('jenis_kelamin', 'P')
                ->count();

            $userBelumVerified = User::where('role', 'user')
                ->where('jurusan_id', $currentUser->jurusan_id)
                ->where('verified', false)
                ->count();

            $userAngkatan2021 = User::where('role', 'user')
                ->where('jurusan_id', $currentUser->jurusan_id)
                ->where('angkatan', '2021')
                ->count();

            $userAngkatan2022 = User::where('role', 'user')
                ->where('jurusan_id', $currentUser->jurusan_id)
                ->where('angkatan', '2022')
                ->count();

            $userAngkatan2023 = User::where('role', 'user')
                ->where('jurusan_id', $currentUser->jurusan_id)
                ->where('angkatan', '2023')
                ->count();

            $userAngkatan2024 = User::where('role', 'user')
                ->where('jurusan_id', $currentUser->jurusan_id)
                ->where('angkatan', '2024')
                ->count();
        }

        // Pagination
        $usersDosen = $queryDosen->paginate(25, ['*'], 'page_dosen')->appends($request->except('page_mahasiswa'));
        $usersMahasiswa = $queryMahasiswa->paginate(25, ['*'], 'page_mahasiswa')->appends($request->except('page_dosen'));

        return view('superadmin.user.index', compact(
            'usersDosen',
            'usersMahasiswa',
            'totalUsers',
            'userMahasiswa',
            'userDosen',
            'userSuperadmin',
            'userLakiLaki',
            'userPerempuan',
            'userBelumVerified',
            'userAngkatan2021',
            'userAngkatan2022',
            'userAngkatan2023',
            'userAngkatan2024'
        ));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:user,admin',
            'jenis_kelamin' => 'nullable|in:L,P',
            'angkatan' => 'nullable|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'prodi_id' => 'nullable|exists:prodis,id',
            'nip' => 'nullable|string|max:255',
            'nim' => 'nullable|string|max:255',
            'verified' => 'nullable|boolean',
        ];

        $validated = $request->validate($rules);

        // Validate prodi belongs to jurusan
        if (!empty($validated['prodi_id']) && !empty($validated['jurusan_id'])) {
            $prodi = Prodi::find($validated['prodi_id']);
            if ($prodi && $prodi->jurusan_id != $validated['jurusan_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Program Studi tidak sesuai dengan Jurusan yang dipilih'
                ], 422);
            }
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'angkatan' => $validated['angkatan'] ?? null,
            'jurusan_id' => $validated['jurusan_id'] ?? null,
            'prodi_id' => $validated['prodi_id'] ?? null,
            'nip' => $validated['nip'] ?? null,
            'nim' => $validated['nim'] ?? null,
            'verified' => $validated['verified'] ?? false,
        ];

        $user = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ]);
    }

    public function show($id)
    {
        $user = User::with(['jurusan', 'prodi'])->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,admin,superadmin',
            'jenis_kelamin' => 'nullable|in:L,P',
            'angkatan' => 'nullable|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'prodi_id' => 'nullable|exists:prodis,id',
            'verified' => 'required|boolean',
            'nip' => 'nullable|string|max:255',
            'nim' => 'nullable|string|max:255',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Validate prodi belongs to jurusan
        if (!empty($validated['prodi_id']) && !empty($validated['jurusan_id'])) {
            $prodi = Prodi::find($validated['prodi_id']);
            if ($prodi && $prodi->jurusan_id != $validated['jurusan_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Program Studi tidak sesuai dengan Jurusan yang dipilih'
                ], 422);
            }
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'angkatan' => $validated['angkatan'] ?? null,
            'jurusan_id' => $validated['jurusan_id'] ?? null,
            'prodi_id' => $validated['prodi_id'] ?? null,
            'verified' => $validated['verified'],
            'nip' => $validated['nip'] ?? null,
            'nim' => $validated['nim'] ?? null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting superadmin if it's the last one
        if ($user->role === 'superadmin' && User::where('role', 'superadmin')->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus superadmin terakhir'
            ], 400);
        }

        // Check if user has karyas
        if ($user->karyas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak dapat dihapus karena memiliki manuskrip terkait'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }

    public function uploadCsvDosen(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120'
        ]);

        try {
            $file = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($csvData);

            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($csvData as $index => $row) {
                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    $data = array_combine($header, $row);

                    // Validate required fields for dosen
                    if (empty($data['name'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Nama wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    if (empty($data['nip'])) {
                        $errors[] = "Baris " . ($index + 2) . ": NIP wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    if (empty($data['email'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Email wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    if (empty($data['password'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Password wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    if (empty($data['jenis_kelamin'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Jenis kelamin wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    if (empty($data['jurusan_id'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Jurusan ID wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    // Remove leading apostrophe from NIP
                    $nip = ltrim($data['nip'], "'");

                    // Check if email already exists
                    if (User::where('email', $data['email'])->exists()) {
                        $errors[] = "Baris " . ($index + 2) . ": Email {$data['email']} sudah terdaftar";
                        $errorCount++;
                        continue;
                    }

                    // Check if NIP already exists
                    if (User::where('nip', $nip)->exists()) {
                        $errors[] = "Baris " . ($index + 2) . ": NIP {$nip} sudah terdaftar";
                        $errorCount++;
                        continue;
                    }

                    // Create user
                    User::create([
                        'name' => $data['name'],
                        'nim' => null,
                        'nip' => $nip,
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                        'jenis_kelamin' => $data['jenis_kelamin'],
                        'angkatan' => null,
                        'jurusan_id' => $data['jurusan_id'],
                        'prodi_id' => !empty($data['prodi_id']) ? $data['prodi_id'] : null,
                        'role' => 'admin',
                        'verified' => false,
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                    $errorCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil mengupload {$successCount} dosen" . ($errorCount > 0 ? ", {$errorCount} gagal" : ""),
                'successCount' => $successCount,
                'errorCount' => $errorCount,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadCsvMahasiswa(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120'
        ]);

        try {
            $file = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($csvData);

            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($csvData as $index => $row) {
                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    $data = array_combine($header, $row);

                    // Validate required fields for mahasiswa
                    if (empty($data['name'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Nama wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    if (empty($data['nim'])) {
                        $errors[] = "Baris " . ($index + 2) . ": NIM wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    if (empty($data['jenis_kelamin'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Jenis kelamin wajib diisi";
                        $errorCount++;
                        continue;
                    }
                    if (empty($data['angkatan'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Angkatan wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    if (empty($data['jurusan_id'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Jurusan ID wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    // Remove leading apostrophe from NIM
                    $nim = ltrim($data['nim'], "'");

                    // Check if NIM already exists
                    if (User::where('nim', $nim)->exists()) {
                        $errors[] = "Baris " . ($index + 2) . ": NIM {$nim} sudah terdaftar";
                        $errorCount++;
                        continue;
                    }

                    // Check if email exists and not empty
                    if (!empty($data['email']) && User::where('email', $data['email'])->exists()) {
                        $errors[] = "Baris " . ($index + 2) . ": Email {$data['email']} sudah terdaftar";
                        $errorCount++;
                        continue;
                    }

                    // Validate prodi_id if provided
                    $prodiId = null;
                    if (!empty($data['prodi_id'])) {
                        $prodi = Prodi::find($data['prodi_id']);
                        if (!$prodi) {
                            $errors[] = "Baris " . ($index + 2) . ": Program Studi ID tidak ditemukan";
                            $errorCount++;
                            continue;
                        }
                        if ($prodi->jurusan_id != $data['jurusan_id']) {
                            $errors[] = "Baris " . ($index + 2) . ": Program Studi tidak sesuai dengan Jurusan yang dipilih";
                            $errorCount++;
                            continue;
                        }
                        $prodiId = $data['prodi_id'];
                    }

                    // Create user
                    User::create([
                        'name' => $data['name'],
                        'nim' => $nim,
                        'nip' => null,
                        'email' => !empty($data['email']) ? $data['email'] : null,
                        'password' => !empty($data['password']) ? Hash::make($data['password']) : Hash::make($nim),
                        'jenis_kelamin' => $data['jenis_kelamin'],
                        'angkatan' => $data['angkatan'],
                        'jurusan_id' => $data['jurusan_id'],
                        'prodi_id' => $prodiId,
                        'role' => 'user',
                        'verified' => false,
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                    $errorCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil mengupload {$successCount} mahasiswa" . ($errorCount > 0 ? ", {$errorCount} gagal" : ""),
                'successCount' => $successCount,
                'errorCount' => $errorCount,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload file: ' . $e->getMessage()
            ], 500);
        }
    }
}
