<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Pendaftaran magang oleh mahasiswa telah dinonaktifkan.
// Pendaftaran sekarang harus dilakukan oleh Admin melalui panel Admin -> Magang.
// Jika perlu mengaktifkan kembali pendaftaran mandiri, restore route berikut dan implementasi controller terkait.
// Route::get('/register-magang', [App\Http\Controllers\RegisterMagangController::class, 'showForm'])->name('register.magang.form')->middleware('auth');
// Route::post('/register-magang', [App\Http\Controllers\RegisterMagangController::class, 'store'])->name('register.magang.store')->middleware('auth');

Route::get('/forgot-password', function () {
    return view('placeholder');
});

// Admin Routes
Route::prefix('admin')->middleware('role:Admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Users Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);

    // Magang Management
    Route::resource('magang', App\Http\Controllers\Admin\MagangController::class);
    Route::post('magang/{id}/terima', [App\Http\Controllers\Admin\MagangController::class, 'terima'])->name('magang.terima');
    Route::post('magang/{id}/tolak', [App\Http\Controllers\Admin\MagangController::class, 'tolak'])->name('magang.tolak');

    // Periode Magang
    Route::resource('periode-magang', App\Http\Controllers\Admin\PeriodeMagangController::class);

    // Unit Bisnis
    Route::resource('unit-bisnis', App\Http\Controllers\Admin\UnitBisnisController::class);

    // Monitoring
    Route::resource('logbook', App\Http\Controllers\LogbookController::class)->only(['index', 'show', 'destroy']);

    // Absensi
    Route::get('/absensi', [App\Http\Controllers\AbsensiController::class, 'index'])->name('admin.absensi.index');
    Route::get('/absensi/{absensi}', [App\Http\Controllers\AbsensiController::class, 'show'])->name('admin.absensi.show');
    Route::delete('/absensi/{absensi}', [App\Http\Controllers\AbsensiController::class, 'destroy'])->name('admin.absensi.destroy');

    // Laporan
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/export-pdf', [App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])->name('admin.laporan.export-pdf');
    Route::get('/laporan/export-excel', [App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])->name('admin.laporan.export-excel');
});

// Pembimbing Routes
Route::prefix('pembimbing')->middleware('role:Pembimbing')->group(function () {
    Route::get('/', [App\Http\Controllers\Pembimbing\DashboardController::class, 'index'])->name('pembimbing.dashboard');

    // Peserta Bimbingan
    Route::get('/peserta', [App\Http\Controllers\Pembimbing\PesertaController::class, 'index'])->name('pembimbing.peserta.index');
    Route::get('/peserta/{id}', [App\Http\Controllers\Pembimbing\PesertaController::class, 'show'])->name('pembimbing.peserta.show');



    // Laporan
    Route::get('/laporan', [App\Http\Controllers\Pembimbing\LaporanController::class, 'index'])->name('pembimbing.laporan.index');
    Route::get('/laporan/export-pdf', [App\Http\Controllers\Pembimbing\LaporanController::class, 'exportPdf'])->name('pembimbing.laporan.export-pdf');
    Route::get('/laporan/export-excel', [App\Http\Controllers\Pembimbing\LaporanController::class, 'exportExcel'])->name('pembimbing.laporan.export-excel');

    // Absensi validation
    Route::get('/absensi', [App\Http\Controllers\AbsensiController::class, 'index'])->name('pembimbing.absensi.index');
    Route::put('/absensi/{absensi}', [App\Http\Controllers\AbsensiController::class, 'update'])->name('pembimbing.absensi.update');
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->middleware('role:Mahasiswa')->group(function () {
    Route::get('/', [App\Http\Controllers\Mahasiswa\DashboardController::class, 'index'])->name('mahasiswa.dashboard');

    // Logbook
    Route::get('/logbook', [App\Http\Controllers\LogbookController::class, 'index'])->name('mahasiswa.logbook.index');
    Route::get('/logbook/create', [App\Http\Controllers\LogbookController::class, 'create'])->name('mahasiswa.logbook.create');
    Route::post('/logbook', [App\Http\Controllers\LogbookController::class, 'store'])->name('mahasiswa.logbook.store');
    Route::get('/logbook/{logbook}/edit', [App\Http\Controllers\LogbookController::class, 'edit'])->name('mahasiswa.logbook.edit');
    Route::put('/logbook/{logbook}', [App\Http\Controllers\LogbookController::class, 'update'])->name('mahasiswa.logbook.update');

    // Absensi
    Route::get('/absensi', [App\Http\Controllers\AbsensiController::class, 'index'])->name('mahasiswa.absensi.index');
    Route::get('/absensi/create', [App\Http\Controllers\AbsensiController::class, 'create'])->name('mahasiswa.absensi.create');
    Route::post('/absensi', [App\Http\Controllers\AbsensiController::class, 'store'])->name('mahasiswa.absensi.store');

    // Profil
    Route::get('/profil', [App\Http\Controllers\Mahasiswa\ProfilController::class, 'index'])->name('mahasiswa.profil.index');
    Route::put('/profil', [App\Http\Controllers\Mahasiswa\ProfilController::class, 'update'])->name('mahasiswa.profil.update');

    // Magang
    // Mahasiswa hanya dapat melihat status magangnya. Pendaftaran magang (create/store)
    // telah dipindahkan ke Admin. Jika mahasiswa ingin mendaftar, mereka harus menghubungi Admin.
    Route::get('/magang', [App\Http\Controllers\Mahasiswa\MagangController::class, 'index'])->name('mahasiswa.magang.index');
    // Route::resource('magang', App\Http\Controllers\MagangController::class)->only(['create', 'store']);


});

Route::prefix('pembimbing')->middleware('role:Pembimbing')->group(function () {
    Route::get('logbook', [App\Http\Controllers\LogbookController::class, 'pembimbingIndex'])->name('pembimbing.logbook.index');
    Route::get('logbook/{logbook}', [App\Http\Controllers\LogbookController::class, 'show'])->name('pembimbing.logbook.show');
    Route::put('logbook/{logbook}', [App\Http\Controllers\LogbookController::class, 'update'])->name('pembimbing.logbook.update');

    // Absensi - untuk validasi/view
    Route::get('/absensi', [App\Http\Controllers\AbsensiController::class, 'index'])->name('pembimbing.absensi.index');
    Route::get('/absensi/{absensi}', [App\Http\Controllers\AbsensiController::class, 'show'])->name('pembimbing.absensi.show');
});
