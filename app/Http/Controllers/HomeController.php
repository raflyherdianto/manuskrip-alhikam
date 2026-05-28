<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKarya;
use App\Models\Karya;
use App\Models\Jurusan;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? null;

        // Ambil semua jenis karya
        $jenisKaryas = JenisKarya::all();

        // Set empty collections untuk mahasiswa dan dosen (jika diperlukan di view)
        $jenisKaryaSiswa = collect([]);

        // Ambil karya terbaru dengan relasi yang diperlukan - order by date
        $karyaTerbaru = Karya::with(['files', 'user.jurusan'])
            ->where('status', 'Terpublish')
            ->where('rights', 'Semua')
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        return view('welcome', compact(
            'jenisKaryas',
            'jenisKaryaSiswa',
            'karyaTerbaru',
            'user'
        ));
    }

    public function jelajahi(Request $request)
    {
        $user = Auth::user() ?? null;

        // Get filter parameters
        $search = $request->input('search');
        $year = $request->input('year');
        $angkatan = $request->input('angkatan');
        $jurusan_id = $request->input('jurusan_id');
        $prodi_id = $request->input('prodi_id');
        $kategori_id = $request->input('kategori_id');
        $jenis_karya_id = $request->input('jenis_karya_id');

        // Query karya with filters - join users table for high performance filtering
        $query = Karya::with(['files', 'user.jurusan', 'user.prodi', 'kategori', 'jenisKarya'])
            ->join('users', 'karyas.user_id', '=', 'users.id')
            ->select('karyas.*')
            ->where('karyas.status', 'Terpublish')
            ->where('karyas.rights', 'Semua');

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('karyas.title', 'like', '%' . $search . '%')
                  ->orWhereHas('kategori', function($subQ) use ($search) {
                      $subQ->where('nama', 'like', '%' . $search . '%');
                  })
                  ->orWhere('users.name', 'like', '%' . $search . '%');
            });
        }

        // Year filter (based on date column)
        if ($year) {
            $query->whereYear('karyas.date', $year);
        }

        // Angkatan filter
        if ($angkatan) {
            $query->where('users.angkatan', $angkatan);
        }

        // Jurusan filter
        if ($jurusan_id) {
            $query->where('users.jurusan_id', $jurusan_id);
        }

        // Prodi filter
        if ($prodi_id) {
            $query->where('users.prodi_id', $prodi_id);
        }

        // Kategori filter
        if ($kategori_id) {
            $query->where('karyas.kategori_id', $kategori_id);
        }

        // Jenis Karya filter
        if ($jenis_karya_id) {
            $query->where('karyas.jenis_karya_id', $jenis_karya_id);
        }

        $karyas = $query->orderBy('karyas.created_at', 'desc')->get();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.karya-grid', compact('karyas'))->render()
            ]);
        }

        // Get filter options
        $years = Karya::selectRaw('YEAR(date) as year')
            ->where('status', 'Terpublish')
            ->where('rights', 'Semua')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $jurusans = Jurusan::orderBy('nama')->get();
        $kategoris = Kategori::orderBy('nama')->get();
        $jenisKaryas = JenisKarya::orderBy('nama')->get();
        $angkatans = \App\Models\User::where('role', 'user')
            ->whereNotNull('angkatan')
            ->distinct()
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');

        return view('jelajahi', compact(
            'karyas',
            'years',
            'jurusans',
            'kategoris',
            'jenisKaryas',
            'angkatans',
            'search',
            'year',
            'angkatan',
            'jurusan_id',
            'prodi_id',
            'kategori_id',
            'jenis_karya_id',
            'user'
        ));
    }

    public function jenisByType($type)
    {
        $jenisKaryas = JenisKarya::where('type', $type)->get();
        $types = Karya::select('type')->distinct()->pluck('type'); // ambil semua type unik

        return view('jenikarya', compact('jenisKaryas', 'type', 'types'));
    }

    public function about()
    {
        return view('aboutus');
    }

    public function faq()
    {
        return view('faq');
    }

    public function guide()
    {
        return view('guide');
    }
}
