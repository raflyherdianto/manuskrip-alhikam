<?php

use App\Http\Middleware\IsLogin;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryaController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DataKaryaController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\KaryaMasukController;
use App\Http\Controllers\KonfirmasiController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\JenisKaryaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionAdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/captcha-refresh', function () {
    return captcha_img();
});

// Public routes - no login required
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('guide', [HomeController::class, 'guide'])->name('guide');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('faq', [HomeController::class, 'faq'])->name('faq');

// Jelajahi route - public access
Route::get('jelajahi', [HomeController::class, 'jelajahi'])->name('jelajahi');

// File download and view routes (requires auth)
Route::get('/files/{fileId}/download', [KaryaController::class, 'downloadFile'])->middleware('auth')->name('file.download');
Route::get('/files/{fileId}/view', [KaryaController::class, 'viewFile'])->middleware('auth')->name('file.view');
Route::get('/files/{fileId}/thumbnail', [KaryaController::class, 'getThumbnail'])->name('file.thumbnail');

// Public routes - karya detail can be viewed without login, but file download requires login
Route::get('/manuskrip/{id}/{nim}/{slug}', [KaryaController::class, 'showDetail'])->name('karya.detail');
Route::get('/manuskrip/{id}', [KaryaController::class, 'show'])->name('karya.show');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [SessionController::class, 'index'])->name('login');
    Route::get('admin/login', [SessionController::class, 'adminLogin'])->name('admin.login');
    Route::get('superadmin/login', [SessionController::class, 'superadminLogin'])->name('superadmin.login');
    Route::post('login', [SessionController::class, 'login'])->name('login.post');

    // Password reset routes
    Route::get('forgot-password', [SessionController::class, 'showForgotPassword'])->name('password.request');
    Route::post('forgot-password', [SessionController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [SessionController::class, 'showResetPassword'])->name('password.reset');
    Route::post('reset-password', [SessionController::class, 'resetPassword'])->name('password.update');
});

Route::post('logout', [SessionController::class, 'logout'])->name('logout');

// User routes - requires login as user
Route::middleware([IsLogin::class, CheckRole::class.':user'])->group(function () {
    Route::get('/unggah/{jenisKarya}', [HomeController::class, 'create'])->name('karya.create');
    Route::post('/unggah', [HomeController::class, 'store'])->name('karya.store');
    Route::get('/manuskrip/{id}/edit', [KaryaController::class, 'edit'])->name('karya.edit');
    Route::patch('/manuskrip/{id}', [KaryaController::class, 'update'])->name('karya.update');
    Route::delete('/manuskrip/{id}', [ActivityController::class, 'destroy'])->name('karya.destroy');
    Route::get('activity', [ActivityController::class, 'index'])->name('activity');
    Route::get('activity/monthly-stats', [ActivityController::class, 'getMonthlyStats'])->name('activity.monthly.stats');
    Route::get('activity/yearly-history', [ActivityController::class, 'getYearlyHistory'])->name('activity.yearly.history');
    Route::get('activitylist', [ActivityController::class, 'activityList'])->name('activitylist');
    Route::get('activity/profile', [ActivityController::class, 'profile'])->name('activity.profile');
    Route::patch('activity/profile', [ActivityController::class, 'updateProfile'])->name('activity.profile.update');

    // Karya upload from activity page routes
    Route::post('activity/manuskrip/store', [KaryaController::class, 'storeFromActivity'])->name('karya.store.activity');
    Route::get('manuskrip/get-jenis', [KaryaController::class, 'getJenisKarya'])->name('karya.get.jenis');
    Route::get('manuskrip/get-kategori', [KaryaController::class, 'getKategori'])->name('karya.get.kategori');
    Route::get('manuskrip/get-pembimbing', [KaryaController::class, 'getPembimbing'])->name('karya.get.pembimbing');
    Route::get('manuskrip/get-languages', [KaryaController::class, 'getLanguages'])->name('karya.get.languages');
});

// Admin routes - requires login as admin
Route::prefix('admin')->middleware([CheckRole::class.':admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Notifications
    Route::get('/notifications', [AdminController::class, 'getNotifications'])->name('admin.notifications');
    Route::post('/notifications/mark-read', [AdminController::class, 'markAsRead'])->name('admin.notifications.mark-read');

    // Sub Jurusan (for dynamic dropdown in user forms)
    Route::get('/kelola-prodi/by-jurusan/{jurusanId}', [ProdiController::class, 'getByJurusan'])->name('admin.kelola-prodi.by-jurusan');

    // Kelola User
    Route::get('/kelola-user', [UserController::class, 'index'])->name('admin.kelola-user');
    Route::post('/kelola-user', [UserController::class, 'store'])->name('admin.kelola-user.store');
    Route::post('/kelola-user/upload-csv-dosen', [UserController::class, 'uploadCsvDosen'])->name('admin.kelola-user.upload-csv-dosen');
    Route::post('/kelola-user/upload-csv-mahasiswa', [UserController::class, 'uploadCsvMahasiswa'])->name('admin.kelola-user.upload-csv-mahasiswa');
    Route::get('/kelola-user/{id}', [UserController::class, 'show'])->name('admin.kelola-user.show');
    Route::put('/kelola-user/{id}', [UserController::class, 'update'])->name('admin.kelola-user.update');
    Route::delete('/kelola-user/{id}', [UserController::class, 'destroy'])->name('admin.kelola-user.destroy');

    // Kelola Karya
    Route::get('/kelola-manuskrip', [KaryaController::class, 'indexAdmin'])->name('admin.kelola-karya');
    Route::get('/kelola-manuskrip/export-excel', [KaryaController::class, 'exportExcel'])->name('admin.kelola-karya.export');
    Route::get('/kelola-manuskrip/{id}', [KaryaController::class, 'showAdmin'])->name('admin.kelola-karya.show');
    Route::put('/kelola-manuskrip/{id}', [KaryaController::class, 'updateAdmin'])->name('admin.kelola-karya.update');
    Route::delete('/kelola-manuskrip/{id}', [KaryaController::class, 'destroyAdmin'])->name('admin.kelola-karya.destroy');
});

// Superadmin routes - requires login as superadmin
Route::prefix('superadmin')->middleware([CheckRole::class.':superadmin'])->group(function () {
    Route::get('/dashboard', [SuperadminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/notifications', [SuperadminController::class, 'getNotifications'])->name('superadmin.notifications');
    Route::post('/notifications/mark-read', [SuperadminController::class, 'markAsRead'])->name('superadmin.notifications.mark-read');
    Route::get('/kelola-bahasa', [LanguageController::class, 'index'])->name('superadmin.kelola-bahasa');
    Route::post('/kelola-bahasa', [LanguageController::class, 'store'])->name('superadmin.kelola-bahasa.store');
    Route::get('/kelola-bahasa/{id}', [LanguageController::class, 'show'])->name('superadmin.kelola-bahasa.show');
    Route::put('/kelola-bahasa/{id}', [LanguageController::class, 'update'])->name('superadmin.kelola-bahasa.update');
    Route::delete('/kelola-bahasa/{id}', [LanguageController::class, 'destroy'])->name('superadmin.kelola-bahasa.destroy');
    Route::get('/kelola-kategori', [KategoriController::class, 'index'])->name('superadmin.kelola-kategori');
    Route::post('/kelola-kategori', [KategoriController::class, 'store'])->name('superadmin.kelola-kategori.store');
    Route::get('/kelola-kategori/{id}', [KategoriController::class, 'show'])->name('superadmin.kelola-kategori.show');
    Route::put('/kelola-kategori/{id}', [KategoriController::class, 'update'])->name('superadmin.kelola-kategori.update');
    Route::delete('/kelola-kategori/{id}', [KategoriController::class, 'destroy'])->name('superadmin.kelola-kategori.destroy');
    Route::get('/kelola-jurusan', [JurusanController::class, 'index'])->name('superadmin.kelola-jurusan');
    Route::post('/kelola-jurusan', [JurusanController::class, 'store'])->name('superadmin.kelola-jurusan.store');
    Route::get('/kelola-jurusan/{id}', [JurusanController::class, 'show'])->name('superadmin.kelola-jurusan.show');
    Route::put('/kelola-jurusan/{id}', [JurusanController::class, 'update'])->name('superadmin.kelola-jurusan.update');
    Route::delete('/kelola-jurusan/{id}', [JurusanController::class, 'destroy'])->name('superadmin.kelola-jurusan.destroy');
    // Prodi Routes
    Route::get('/kelola-prodi', [ProdiController::class, 'index'])->name('superadmin.kelola-prodi');
    Route::post('/kelola-prodi', [ProdiController::class, 'store'])->name('superadmin.kelola-prodi.store');
    Route::get('/kelola-prodi/by-jurusan/{jurusanId}', [ProdiController::class, 'getByJurusan'])->name('superadmin.kelola-prodi.by-jurusan');
    Route::get('/kelola-prodi/{id}', [ProdiController::class, 'show'])->name('superadmin.kelola-prodi.show');
    Route::put('/kelola-prodi/{id}', [ProdiController::class, 'update'])->name('superadmin.kelola-prodi.update');
    Route::delete('/kelola-prodi/{id}', [ProdiController::class, 'destroy'])->name('superadmin.kelola-prodi.destroy');
    Route::get('/kelola-manuskrip', [KaryaController::class, 'indexSuperadmin'])->name('superadmin.kelola-karya');
    Route::get('/kelola-manuskrip/export-excel', [KaryaController::class, 'exportExcel'])->name('superadmin.kelola-karya.export');
    Route::get('/kelola-manuskrip/{id}', [KaryaController::class, 'showSuperadmin'])->name('superadmin.kelola-karya.show');
    Route::put('/kelola-manuskrip/{id}', [KaryaController::class, 'updateSuperadmin'])->name('superadmin.kelola-karya.update');
    Route::delete('/kelola-manuskrip/{id}', [KaryaController::class, 'destroySuperadmin'])->name('superadmin.kelola-karya.destroy');
    Route::get('/kelola-jenis-manuskrip', [JenisKaryaController::class, 'index'])->name('superadmin.kelola-jenis-karya');
    Route::post('/kelola-jenis-manuskrip', [JenisKaryaController::class, 'store'])->name('superadmin.kelola-jenis-karya.store');
    Route::get('/kelola-jenis-manuskrip/{id}', [JenisKaryaController::class, 'show'])->name('superadmin.kelola-jenis-karya.show');
    Route::put('/kelola-jenis-manuskrip/{id}', [JenisKaryaController::class, 'update'])->name('superadmin.kelola-jenis-karya.update');
    Route::delete('/kelola-jenis-manuskrip/{id}', [JenisKaryaController::class, 'destroy'])->name('superadmin.kelola-jenis-karya.destroy');
    Route::get('/kelola-user', [UserController::class, 'index'])->name('superadmin.kelola-user');
    Route::post('/kelola-user', [UserController::class, 'store'])->name('superadmin.kelola-user.store');
    Route::post('/kelola-user/upload-csv-dosen', [UserController::class, 'uploadCsvDosen'])->name('superadmin.kelola-user.upload-csv-dosen');
    Route::post('/kelola-user/upload-csv-mahasiswa', [UserController::class, 'uploadCsvMahasiswa'])->name('superadmin.kelola-user.upload-csv-mahasiswa');
    Route::get('/kelola-user/{id}', [UserController::class, 'show'])->name('superadmin.kelola-user.show');
    Route::put('/kelola-user/{id}', [UserController::class, 'update'])->name('superadmin.kelola-user.update');
    Route::delete('/kelola-user/{id}', [UserController::class, 'destroy'])->name('superadmin.kelola-user.destroy');
    // Add more superadmin routes here
});
