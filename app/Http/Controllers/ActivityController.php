<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use App\Models\Karya;
use App\Models\User;
use App\Models\JenisKarya;
use App\Models\Kategori;
use App\Models\Language;
use App\Mail\AccountVerified;

class ActivityController extends Controller
{
    public function index(Request $request){
        $user = Auth::user(); // Ambil user login

        // Redirect to profile if user is not verified
        if (!$user->verified) {
            return redirect()->route('activity.profile')->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu untuk verifikasi.');
        }

        $currentYear = now()->year;

        // Handle DataTables AJAX request
        if ($request->ajax()) {
            $karyas = Karya::where('user_id', $user->id)
                ->with(['kategori', 'user', 'pembimbing'])
                ->select('karyas.*');

            return datatables()->of($karyas)
                ->addColumn('subjek', function($karya) {
                    return $karya->kategori ? $karya->kategori->nama : '-';
                })
                ->addColumn('kategori', function($karya) {
                    return $karya->kategori ? $karya->kategori->nama : '-';
                })
                ->addColumn('kontributor', function($karya) {
                    return $karya->pembimbing ? $karya->pembimbing->name : '-';
                })
                ->addColumn('keterangan', function($karya) {
                    return $karya->keterangan ?? '-';
                })
                ->editColumn('status', function($karya) {
                    $badgeClass = '';
                    $statusText = '';

                    switch($karya->status) {
                        case 'Menunggu':
                            $badgeClass = 'bg-warning';
                            $statusText = 'Menunggu';
                            break;
                        case 'Terpublish':
                            $badgeClass = 'bg-success';
                            $statusText = 'Terpublish';
                            break;
                        case 'Ditolak':
                            $badgeClass = 'bg-danger';
                            $statusText = 'Ditolak';
                            break;
                        case 'Arsip':
                            $badgeClass = 'bg-secondary';
                            $statusText = 'Arsip';
                            break;
                        default:
                            $badgeClass = 'bg-secondary';
                            $statusText = $karya->status;
                    }

                    return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
                })
                ->addColumn('aksi', function($karya) {
                    return '
                        <div class="d-flex gap-1" style="white-space: nowrap;">
                            <button type="button" class="btn btn-primary btn-sm btn-detail" data-id="'.$karya->id.'" style="min-width: 70px;">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="'.$karya->id.'" style="min-width: 70px;">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="'.route('karya.destroy', $karya->id).'" method="POST" style="display:inline;" class="delete-form">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-danger btn-sm" style="min-width: 70px;" onclick="return confirm(\'Yakin ingin menghapus manuskrip ini?\')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->editColumn('description', function($karya) {
                    // Convert HTML to plain text while preserving line breaks
                    $text = str_replace(['</p>', '<br>', '<br/>', '<br />'], "\n", $karya->description);
                    $plainText = strip_tags($text);
                    $plainText = trim(preg_replace('/\n\s*\n/', "\n", $plainText));

                    if (mb_strlen($plainText) > 100) {
                        $truncated = mb_substr($plainText, 0, 100);
                        // Find last space to avoid cutting words
                        $lastSpace = mb_strrpos($truncated, ' ');
                        if ($lastSpace !== false) {
                            $truncated = mb_substr($truncated, 0, $lastSpace);
                        }
                        return nl2br($truncated . '...');
                    }
                    return nl2br($plainText);
                })
                ->rawColumns(['aksi', 'description', 'status'])
                ->make(true);
        }

        // Ambil hanya 3 tahun terakhir dan hanya karya milik user login
        $yearlyData = DB::table('karyas')
            ->selectRaw('YEAR(date) as year, COUNT(*) as total')
            ->where('user_id', $user->id) // ✅ Tambahkan filter berdasarkan user login
            ->whereBetween(DB::raw('YEAR(date)'), [$currentYear - 2, $currentYear])
            ->groupByRaw('YEAR(date)')
            ->orderBy('year')
            ->pluck('total', 'year');

        $years = $yearlyData->keys();       // Contoh: [2023, 2024, 2025]
        $totals = $yearlyData->values();    // Contoh: [5, 12, 7]

        // Statistik tambahan untuk dashboard
        $totalKarya = Karya::where('user_id', $user->id)->count();
        $karyaDiterima = Karya::where('user_id', $user->id)->where('status', 'Terpublish')->count();
        $karyaMenunggu = Karya::where('user_id', $user->id)->where('status', 'Menunggu')->count();
        $karyaTahunIni = Karya::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->count();

        // Load dropdown data
        $jenisKaryas = JenisKarya::orderBy('nama', 'asc')->get();
        $kategoris = Kategori::orderBy('nama', 'asc')->get();
        $pembimbings = User::where('role', 'admin')->orderBy('name', 'asc')->get();
        $languages = Language::orderBy('nama', 'asc')->get();

        return view('activity.index', [
            'years' => $years,
            'totals' => $totals,
            'totalKarya' => $totalKarya,
            'karyaDiterima' => $karyaDiterima,
            'karyaMenunggu' => $karyaMenunggu,
            'karyaTahunIni' => $karyaTahunIni,
            'jenisKaryas' => $jenisKaryas,
            'kategoris' => $kategoris,
            'subjeks' => $kategoris,
            'pembimbings' => $pembimbings,
            'languages' => $languages,
        ]);
    }

    // Get monthly statistics for a specific year
    public function getMonthlyStats(Request $request)
    {
        $user = Auth::user();
        $year = $request->input('year', now()->year);

        $monthlyData = DB::table('karyas')
            ->selectRaw('MONTH(date) as month, COUNT(*) as total')
            ->where('user_id', $user->id)
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Create array with all 12 months
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $totals = [];

        for ($i = 1; $i <= 12; $i++) {
            $totals[] = $monthlyData->get($i, 0);
        }

        return response()->json([
            'months' => $months,
            'totals' => $totals,
            'year' => $year
        ]);
    }

    // Get all yearly statistics for history modal
    public function getYearlyHistory(Request $request)
    {
        $user = Auth::user();

        $yearlyHistory = DB::table('karyas')
            ->selectRaw('YEAR(date) as year, COUNT(*) as total')
            ->where('user_id', $user->id)
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        return response()->json([
            'history' => $yearlyHistory
        ]);
    }

    public function activitylist()
    {
        $user = Auth::user();

        // Ambil semua karya milik user login
        $karyas = Karya::where('user_id', $user->id)->with(['kategori', 'pembimbing'])->get();

        return view('activity.activitylist', compact('karyas'));
    }

    public function destroy($id)
    {
        $karya = Karya::with('files')->findOrFail($id);

        // Optional: pastikan hanya pemilik yang bisa menghapus
        if ($karya->user_id != Auth::id()) {
            abort(403);
        }

        // Hapus semua file fisik dari storage
        foreach ($karya->files as $file) {
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }

            // Hapus thumbnail jika ada
            if ($file->thumbnail && Storage::disk('public')->exists($file->thumbnail)) {
                Storage::disk('public')->delete($file->thumbnail);
            }
        }

        // Hapus karya (akan otomatis menghapus records di karya_files karena cascade)
        $karya->delete();

        return redirect()->back()->with('success', 'Manuskrip dan semua file berhasil dihapus.');
    }

    public function profile()
    {
        return view('activity.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        // Check if user was not verified before
        $wasNotVerified = !$user->verified;

        // Check if user updated email or password
        $emailChanged = ($user->email !== $validated['email']);
        $passwordChanged = !empty($validated['password']);

        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        User::where('id', $user->id)->update([
            'email' => $user->email,
            'password' => $user->password,
            'verified' => true,
            'updated_at' => now(),
        ]);

        // Kirim email jika user sebelumnya belum verified dan role = user
        if ($wasNotVerified && $user->role === 'user' && ($emailChanged || $passwordChanged)) {
            try {
                $activityUrl = route('activity');

                Mail::to($user->email)->send(
                    new AccountVerified(
                        $user->name,
                        $user->email,
                        $passwordChanged,
                        $activityUrl
                    )
                );

                Log::info('Account verification email sent successfully to: ' . $user->email);
            } catch (\Exception $emailException) {
                // Log error tapi tidak menghentikan proses
                Log::error('Failed to send account verification email: ' . $emailException->getMessage());
            }
        }

        // Show toast message only for verified users
        if ($user->verified && ($emailChanged || $passwordChanged)) {
            return redirect()->route('activity.profile')->with('success', 'Data berhasil diubah');
        }

        return redirect()->route('activity.profile')->with('success', 'Profil berhasil diperbarui!');
    }

}
