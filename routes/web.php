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
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/register-magang', function () {
    return view('auth.register-magang');
});

Route::post('/register-magang', function () {
    return redirect('/')->with('success', 'Pendaftaran berhasil dikirim!');
});

Route::get('/forgot-password', function () {
    return view('placeholder');
});

// Admin Routes
Route::prefix('admin')->middleware('role:Admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });

    // Users Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);

    // Magang Management
    Route::resource('magang', App\Http\Controllers\Admin\MagangController::class);

    // Periode Magang
    Route::resource('periode-magang', App\Http\Controllers\Admin\PeriodeMagangController::class);

    // Unit Bisnis
    Route::resource('unit-bisnis', App\Http\Controllers\Admin\UnitBisnisController::class);

    // Monitoring
    Route::get('/logbook', function () {
        return view('admin.logbook.index');
    });
    Route::get('/logbook/{id}', function () {
        return view('admin.logbook.show');
    });

    // Absensi
    Route::resource('absensi', App\Http\Controllers\AbsensiController::class)->only(['index']);

    // Penilaian & Laporan
    Route::get('/penilaian', function () {
        return view('admin.penilaian.index');
    });
    Route::get('/penilaian/{id}', function () {
        return view('admin.penilaian.show');
    });
    Route::get('/penilaian/{id}/edit', function () {
        return view('admin.penilaian.edit');
    });
    Route::put('/penilaian/{id}', function () {
        return redirect('/admin/penilaian')->with('success', 'Penilaian berhasil diupdate');
    });
    Route::get('/laporan', function () {
        return view('admin.laporan.index');
    });
});

// Pembimbing Routes
Route::prefix('pembimbing')->middleware('role:Pembimbing')->group(function () {
    Route::get('/', function () {
        $peserta_count = 8;
        $logbook_pending = 12;
        $absensi_hadir = 8;
        $absensi_total = 8;
        return view('pembimbing.dashboard', compact('peserta_count', 'logbook_pending', 'absensi_hadir', 'absensi_total'));
    });

    // Peserta Bimbingan
    Route::get('/peserta', function () {
        return view('pembimbing.peserta.index');
    });
    Route::get('/peserta/{id}', function () {
        return view('pembimbing.peserta.show');
    });

    // Penilaian
    Route::get('/penilaian', function () {
        return view('pembimbing.penilaian.index');
    });
    Route::get('/penilaian/{id}', function () {
        return view('pembimbing.penilaian.edit');
    });
    Route::post('/penilaian', function () {
        return redirect('/pembimbing/penilaian')->with('success', 'Penilaian berhasil disimpan');
    });

    // Laporan
    Route::get('/laporan', function () {
        return view('pembimbing.laporan.index');
    });
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->middleware('role:Mahasiswa')->group(function () {
    Route::get('/', function () {
        $status_magang = 'Aktif';
        $unit_penempatan = 'IT Support';
        $kehadiran_persen = 95;
        $kehadiran_total = 19;
        $kehadiran_max = 20;
        $logbook_minggu_ini = 4;
        $logbook_target = 5;
        return view('mahasiswa.dashboard', compact(
            'status_magang',
            'unit_penempatan',
            'kehadiran_persen',
            'kehadiran_total',
            'kehadiran_max',
            'logbook_minggu_ini',
            'logbook_target'
        ));
    });

    // Logbook
    Route::resource('logbook', App\Http\Controllers\LogbookController::class)->only(['index', 'create', 'store', 'edit', 'update']);

    // Absensi
    Route::resource('absensi', App\Http\Controllers\AbsensiController::class)->only(['index', 'create', 'store']);

    // Profil
    Route::get('/profil', function () {
        return view('mahasiswa.profil.index');
    });
    Route::put('/profil', function () {
        return redirect('/mahasiswa/profil')->with('success', 'Profil berhasil diperbarui');
    });

    // Magang
    Route::get('/magang', [App\Http\Controllers\Mahasiswa\MagangController::class, 'index'])->name('mahasiswa.magang.index');
    Route::resource('magang', App\Http\Controllers\MagangController::class)->only(['create', 'store']);

    // Nilai
    Route::get('/nilai', function () {
        return view('mahasiswa.nilai.index');
    });
});

// Admin Routes
Route::prefix('admin')->middleware('role:Admin')->group(function () {
    Route::resource('logbook', App\Http\Controllers\LogbookController::class)->only(['index', 'edit', 'update', 'destroy']);
});

Route::prefix('pembimbing')->middleware('role:Pembimbing')->group(function () {
    Route::get('logbook', [App\Http\Controllers\LogbookController::class, 'pembimbingIndex'])->name('pembimbing.logbook.index');
    Route::put('logbook/{logbook}', [App\Http\Controllers\LogbookController::class, 'update'])->name('pembimbing.logbook.update');
});
