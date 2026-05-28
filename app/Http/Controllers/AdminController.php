<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Karya;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $isAdmin = $currentUser->role === 'admin';
        $jurusanId = $currentUser->jurusan_id;

        // Total Mahasiswa - users dengan role = user
        $totalMahasiswaQuery = User::where('role', 'user');
        if ($isAdmin && $jurusanId) {
            $totalMahasiswaQuery->where('jurusan_id', $jurusanId);
        }
        $totalMahasiswa = $totalMahasiswaQuery->count();

        // Total Karya - total dari tabel karyas
        $totalKaryaQuery = Karya::query();
        if ($isAdmin && $jurusanId) {
            $totalKaryaQuery->whereHas('user', function($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            });
        }
        $totalKarya = $totalKaryaQuery->count();

        // Karya Menunggu Verifikasi - karyas dengan status = Menunggu
        $karyaMenungguQuery = Karya::where('status', 'Menunggu');
        if ($isAdmin && $jurusanId) {
            $karyaMenungguQuery->whereHas('user', function($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            });
        }
        $karyaMenunggu = $karyaMenungguQuery->count();

        // User Belum Terverifikasi - users dengan role = user dan verified = false
        $userBelumVerifikasiQuery = User::where('role', 'user')->where('verified', false);
        if ($isAdmin && $jurusanId) {
            $userBelumVerifikasiQuery->where('jurusan_id', $jurusanId);
        }
        $userBelumVerifikasi = $userBelumVerifikasiQuery->count();

        // Distribusi Karya per Jurusan (hanya untuk superadmin)
        $distribusiKarya = collect();
        if (!$isAdmin) {
            $distribusiKarya = Jurusan::select('jurusans.nama', DB::raw('COUNT(karyas.id) as total'))
                                    ->leftJoin('users', 'jurusans.id', '=', 'users.jurusan_id')
                                    ->leftJoin('karyas', 'users.id', '=', 'karyas.user_id')
                                    ->groupBy('jurusans.id', 'jurusans.nama')
                                    ->orderBy('total', 'desc')
                                    ->get();

            // Hitung total karya untuk persentase
            $totalKaryaForPercent = $distribusiKarya->sum('total');

            // Tambahkan persentase ke setiap item
            $distribusiKarya = $distribusiKarya->map(function($item) use ($totalKaryaForPercent) {
                $item->percentage = $totalKaryaForPercent > 0 ? round(($item->total / $totalKaryaForPercent) * 100, 1) : 0;
                return $item;
            });
        }

        // Warna untuk setiap jurusan
        $colors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6'];

        // Distribusi Karya per Kategori - tampilkan semua kategori
        if ($isAdmin && $jurusanId) {
            // Untuk admin: filter berdasarkan jurusan
            $distribusiKategori = DB::table('kategoris')
                ->select('kategoris.nama', DB::raw('COALESCE(COUNT(karyas.id), 0) as total'))
                ->leftJoin('karyas', function($join) use ($jurusanId) {
                    $join->on('kategoris.id', '=', 'karyas.kategori_id')
                         ->join('users', 'karyas.user_id', '=', 'users.id')
                         ->where('users.jurusan_id', '=', $jurusanId);
                })
                ->groupBy('kategoris.id', 'kategoris.nama')
                ->orderBy('total', 'desc')
                ->get();
        } else {
            // Untuk superadmin: tampilkan semua
            $distribusiKategori = DB::table('kategoris')
                ->select('kategoris.nama', DB::raw('COALESCE(COUNT(karyas.id), 0) as total'))
                ->leftJoin('karyas', 'kategoris.id', '=', 'karyas.kategori_id')
                ->groupBy('kategoris.id', 'kategoris.nama')
                ->orderBy('total', 'desc')
                ->get();
        }

        $totalKategoriForPercent = $distribusiKategori->sum('total');
        $distribusiKategori = $distribusiKategori->map(function($item) use ($totalKategoriForPercent) {
            $item->percentage = $totalKategoriForPercent > 0 ? round(($item->total / $totalKategoriForPercent) * 100, 1) : 0;
            return $item;
        });

        // Distribusi Karya per Jenis Karya
        $distribusiJenis = collect();
        try {
            if ($isAdmin && $jurusanId) {
                // Untuk admin: filter berdasarkan jurusan
                $distribusiJenis = DB::table('jenis_karyas')
                    ->select('jenis_karyas.nama', DB::raw('COALESCE(COUNT(karyas.id), 0) as total'))
                    ->leftJoin('karyas', function($join) use ($jurusanId) {
                        $join->on('jenis_karyas.id', '=', 'karyas.jenis_karya_id')
                             ->join('users', 'karyas.user_id', '=', 'users.id')
                             ->where('users.jurusan_id', '=', $jurusanId);
                    })
                    ->groupBy('jenis_karyas.id', 'jenis_karyas.nama')
                    ->orderBy('total', 'desc')
                    ->get();
            } else {
                // Untuk superadmin: tampilkan semua tanpa filter jurusan
                $distribusiJenis = DB::table('jenis_karyas')
                    ->select('jenis_karyas.nama', DB::raw('COALESCE(COUNT(karyas.id), 0) as total'))
                    ->leftJoin('karyas', 'jenis_karyas.id', '=', 'karyas.jenis_karya_id')
                    ->groupBy('jenis_karyas.id', 'jenis_karyas.nama')
                    ->orderBy('total', 'desc')
                    ->get();
            }
        } catch (\Exception $e) {
            $distribusiJenis = collect();
        }

        $totalJenisForPercent = $distribusiJenis->sum('total');
        $distribusiJenis = $distribusiJenis->map(function($item) use ($totalJenisForPercent) {
            $item->percentage = $totalJenisForPercent > 0 ? round(($item->total / $totalJenisForPercent) * 100, 1) : 0;
            return $item;
        });

        // Activities - mengambil notifikasi terbaru
        $activities = collect();

        $notificationsQuery = DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->limit(10);

        // Filter notifications berdasarkan jurusan_id untuk admin
        if ($isAdmin && $jurusanId) {
            $notificationsQuery->where(function($query) use ($jurusanId) {
                $query->whereRaw("JSON_EXTRACT(data, '$.karya_id') IN (
                    SELECT k.id
                    FROM karyas k
                    INNER JOIN users u ON k.user_id = u.id
                    WHERE u.jurusan_id = ?
                )", [$jurusanId]);
            });
        }

        $notifications = $notificationsQuery->get();

        foreach ($notifications as $notification) {
            $data = json_decode($notification->data, true);

            // Notifikasi karya baru dari user
            if (isset($data['type']) && $data['type'] === 'karya_new' && isset($data['karya_id'])) {
                $activities->push([
                    'type' => 'new',
                    'data' => $data,
                    'created_at' => $notification->created_at
                ]);
            }

            // Notifikasi karya dipublikasi oleh admin
            if (isset($data['karya_id']) && isset($data['admin_id']) && $data['admin_id'] !== null) {
                $activities->push([
                    'type' => 'published',
                    'data' => $data,
                    'created_at' => $notification->created_at
                ]);
            }
        }

        $activities = $activities->sortByDesc('created_at')->take(10);

        return view('superadmin.index', compact(
            'totalMahasiswa',
            'totalKarya',
            'karyaMenunggu',
            'userBelumVerifikasi',
            'distribusiKarya',
            'distribusiKategori',
            'distribusiJenis',
            'colors',
            'activities'
        ));
    }

    public function getNotifications()
    {
        $currentUser = Auth::user();
        $isAdmin = $currentUser->role === 'admin';
        $jurusanId = $currentUser->jurusan_id;

        $notificationsQuery = DB::table('notifications')
            ->orderBy('created_at', 'desc');

        // Filter notifications berdasarkan jurusan_id untuk admin
        if ($isAdmin && $jurusanId) {
            $notificationsQuery->where(function($query) use ($jurusanId) {
                $query->whereRaw("JSON_EXTRACT(data, '$.karya_id') IN (
                    SELECT k.id
                    FROM karyas k
                    INNER JOIN users u ON k.user_id = u.id
                    WHERE u.jurusan_id = ?
                )", [$jurusanId]);
            });
        }

        $notifications = $notificationsQuery->get()
            ->map(function($notification) {
                $data = json_decode($notification->data, true);

                // Notifikasi karya baru dari user
                if (isset($data['type']) && $data['type'] === 'karya_new' && isset($data['karya_id'])) {
                    $karya = Karya::find($data['karya_id']);
                    $user = isset($data['user_id']) ? User::find($data['user_id']) : null;

                    if ($karya) {
                        $userName = $user ? $user->name : 'User';
                        $createdAt = \Carbon\Carbon::parse($notification->created_at);

                        return [
                            'id' => $notification->id,
                            'type' => 'new',
                            'message' => "{$userName} mengunggah manuskrip baru \"{$karya->title}\"",
                            'title' => 'Manuskrip baru menunggu verifikasi',
                            'created_at' => $notification->created_at,
                            'time_ago' => $createdAt->diffForHumans(),
                            'read_at' => $notification->read_at
                        ];
                    }
                }

                // Notifikasi karya dipublikasi oleh admin
                if (isset($data['karya_id']) && isset($data['admin_id']) && $data['admin_id'] !== null) {
                    // Ambil data karya
                    $karya = Karya::find($data['karya_id']);
                    // Ambil data admin yang mempublikasi
                    $admin = User::find($data['admin_id']);

                    if ($karya && $admin) {
                        // Clean admin name - skip titles
                        $adminName = $admin->name;
                        $titles = ['Ir.', 'Prof.', 'Dr.', 'dr.'];
                        foreach ($titles as $title) {
                            $adminName = preg_replace('/^' . preg_quote($title, '/') . '\s*/i', '', $adminName);
                        }
                        // Get first name only
                        $firstName = explode(' ', trim($adminName))[0];
                        $createdAt = \Carbon\Carbon::parse($notification->created_at);

                        return [
                            'id' => $notification->id,
                            'type' => 'published',
                            'message' => "Dosen {$firstName} telah mempublikasi manuskrip \"{$karya->title}\"",
                            'title' => 'Manuskrip baru dipublikasi',
                            'created_at' => $notification->created_at,
                            'time_ago' => $createdAt->diffForHumans(),
                            'read_at' => $notification->read_at
                        ];
                    }
                }

                return null;
            })
            ->filter();

        return response()->json($notifications);
    }

    public function markAsRead()
    {
        $currentUser = Auth::user();
        $isAdmin = $currentUser->role === 'admin';
        $jurusanId = $currentUser->jurusan_id;

        $query = DB::table('notifications')
            ->whereNull('read_at');

        // Filter notifications berdasarkan jurusan_id untuk admin
        if ($isAdmin && $jurusanId) {
            $query->where(function($q) use ($jurusanId) {
                $q->whereRaw("JSON_EXTRACT(data, '$.karya_id') IN (
                    SELECT k.id
                    FROM karyas k
                    INNER JOIN users u ON k.user_id = u.id
                    WHERE u.jurusan_id = ?
                )", [$jurusanId]);
            });
        }

        $query->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
