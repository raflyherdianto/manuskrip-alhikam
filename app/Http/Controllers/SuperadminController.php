<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Karya;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;

class SuperadminController extends Controller
{
    public function dashboard()
    {
        // Total Mahasiswa - users dengan role = user
        $totalMahasiswa = User::where('role', 'user')->count();

        // Total Karya - total dari tabel karyas
        $totalKarya = Karya::count();

        // Karya Menunggu Verifikasi - karyas dengan status = Menunggu
        $karyaMenunggu = Karya::where('status', 'Menunggu')->count();

        // User Belum Terverifikasi - users dengan role = user dan verified = false
        $userBelumVerifikasi = User::where('role', 'user')
                                    ->where('verified', false)
                                    ->count();

        // Distribusi Karya per Jurusan - menggunakan data dari tabel jurusans melalui users
        // Menggunakan leftJoin agar jurusan tanpa karya tetap tampil
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

        // Warna untuk setiap jurusan (rotasi warna)
        $colors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6'];

        // Ambil notifications dari database
        $notifications = DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Total notifications yang belum dibaca
        $unreadCount = DB::table('notifications')
            ->whereNull('read_at')
            ->count();

        // Aktivitas terbaru
        $activities = collect();

        // 1. Loop semua notifications
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

        // Sort by created_at
        $activities = $activities->sortByDesc('created_at')->take(10);

        // Distribusi Karya per Kategori
        $distribusiKategori = DB::table('kategoris')
            ->select('kategoris.nama', DB::raw('COALESCE(COUNT(karyas.id), 0) as total'))
            ->leftJoin('karyas', 'kategoris.id', '=', 'karyas.kategori_id')
            ->groupBy('kategoris.id', 'kategoris.nama')
            ->orderBy('total', 'desc')
            ->get();

        // Hitung total karya untuk persentase kategori
        $totalKaryaKategori = $distribusiKategori->sum('total');

        // Tambahkan persentase ke setiap kategori
        $distribusiKategori = $distribusiKategori->map(function($item) use ($totalKaryaKategori) {
            $item->percentage = $totalKaryaKategori > 0 ? round(($item->total / $totalKaryaKategori) * 100, 1) : 0;
            return $item;
        });

        // Distribusi Karya per Jenis Karya
        $distribusiJenis = collect();
        try {
            $distribusiJenis = DB::table('jenis_karyas')
                ->select('jenis_karyas.nama', DB::raw('COALESCE(COUNT(karyas.id), 0) as total'))
                ->leftJoin('karyas', 'jenis_karyas.id', '=', 'karyas.jenis_karya_id')
                ->groupBy('jenis_karyas.id', 'jenis_karyas.nama')
                ->orderBy('total', 'desc')
                ->get();
        } catch (\Exception $e) {
            $distribusiJenis = collect();
        }

        $totalJenisForPercent = $distribusiJenis->sum('total');
        $distribusiJenis = $distribusiJenis->map(function($item) use ($totalJenisForPercent) {
            $item->percentage = $totalJenisForPercent > 0 ? round(($item->total / $totalJenisForPercent) * 100, 1) : 0;
            return $item;
        });

        return view('superadmin.index', compact(
            'totalMahasiswa',
            'totalKarya',
            'karyaMenunggu',
            'userBelumVerifikasi',
            'distribusiKarya',
            'distribusiKategori',
            'distribusiJenis',
            'colors',
            'activities',
            'unreadCount',
            'notifications'
        ));
    }

    public function getNotifications()
    {
        $notifications = DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->get()
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
        DB::table('notifications')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
