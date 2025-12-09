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

Route::get('/register-magang', [App\Http\Controllers\RegisterMagangController::class, 'showForm'])->name('register.magang.form')->middleware('auth');
Route::post('/register-magang', [App\Http\Controllers\RegisterMagangController::class, 'store'])->name('register.magang.store')->middleware('auth');

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
    Route::resource('logbook', App\Http\Controllers\LogbookController::class)->only(['index', 'edit', 'update', 'destroy']);

    // Absensi
    Route::resource('absensi', App\Http\Controllers\AbsensiController::class);

    // Penilaian & Laporan
    Route::get('/penilaian', [App\Http\Controllers\Admin\PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/{id}', [App\Http\Controllers\Admin\PenilaianController::class, 'show'])->name('penilaian.show');
    Route::get('/penilaian/{id}/edit', [App\Http\Controllers\Admin\PenilaianController::class, 'edit'])->name('penilaian.edit');
    Route::put('/penilaian/{id}', [App\Http\Controllers\Admin\PenilaianController::class, 'update'])->name('penilaian.update');
    Route::delete('/penilaian/{id}', [App\Http\Controllers\Admin\PenilaianController::class, 'destroy'])->name('penilaian.destroy');
    Route::get('/laporan', function () {
        return view('admin.laporan.index');
    });
});

// Pembimbing Routes
Route::prefix('pembimbing')->middleware('role:Pembimbing')->group(function () {
    Route::get('/', [App\Http\Controllers\Pembimbing\DashboardController::class, 'index'])->name('pembimbing.dashboard');

    // Peserta Bimbingan
    Route::get('/peserta', [App\Http\Controllers\Pembimbing\PesertaController::class, 'index'])->name('pembimbing.peserta.index');
    Route::get('/peserta/{id}', [App\Http\Controllers\Pembimbing\PesertaController::class, 'show'])->name('pembimbing.peserta.show');

    // Penilaian
    Route::get('/penilaian', [App\Http\Controllers\Pembimbing\PenilaianController::class, 'index'])->name('pembimbing.penilaian.index');
    Route::get('/penilaian/create/{magang}', [App\Http\Controllers\Pembimbing\PenilaianController::class, 'create'])->name('pembimbing.penilaian.create');
    Route::post('/penilaian', [App\Http\Controllers\Pembimbing\PenilaianController::class, 'store'])->name('pembimbing.penilaian.store');
    Route::get('/penilaian/{id}', [App\Http\Controllers\Pembimbing\PenilaianController::class, 'show'])->name('pembimbing.penilaian.show');
    Route::get('/penilaian/{id}/edit', [App\Http\Controllers\Pembimbing\PenilaianController::class, 'edit'])->name('pembimbing.penilaian.edit');
    Route::put('/penilaian/{id}', [App\Http\Controllers\Pembimbing\PenilaianController::class, 'update'])->name('pembimbing.penilaian.update');

    // Laporan
    Route::get('/laporan', function () {
        return view('pembimbing.laporan.index');
    });

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
    Route::get('/magang', [App\Http\Controllers\Mahasiswa\MagangController::class, 'index'])->name('mahasiswa.magang.index');
    Route::resource('magang', App\Http\Controllers\MagangController::class)->only(['create', 'store']);

    // Nilai
    Route::get('/nilai', [App\Http\Controllers\Mahasiswa\NilaiController::class, 'index'])->name('mahasiswa.nilai.index');
});

Route::prefix('pembimbing')->middleware('role:Pembimbing')->group(function () {
    Route::get('logbook', [App\Http\Controllers\LogbookController::class, 'pembimbingIndex'])->name('pembimbing.logbook.index');
    Route::get('logbook/{logbook}', [App\Http\Controllers\LogbookController::class, 'show'])->name('pembimbing.logbook.show');
    Route::put('logbook/{logbook}', [App\Http\Controllers\LogbookController::class, 'update'])->name('pembimbing.logbook.update');
});
