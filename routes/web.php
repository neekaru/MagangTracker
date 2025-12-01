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

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    // Dummy login logic for prototype
    $email = $request->input('email');
    if (str_contains($email, 'admin')) {
        // Simulate Admin Login
        // In real app: Auth::login($user);
        return redirect('/admin');
    } elseif (str_contains($email, 'dosen') || str_contains($email, 'pembimbing')) {
        return redirect('/pembimbing');
    } else {
        return redirect('/mahasiswa');
    }
});

Route::post('/logout', function () {
    // Auth::logout();
    return redirect('/');
})->name('logout');

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
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    
    // Users Management
    Route::get('/users', function () { return view('admin.users.index'); });
    Route::get('/users/create', function () { return view('admin.users.create'); });
    Route::post('/users', function () { return redirect('/admin/users')->with('success', 'User berhasil ditambahkan'); });
    
    // Magang Management
    Route::get('/magang', function () { return view('admin.magang.index'); });
    
    // Periode Magang
    Route::get('/periode-magang', function () { return view('admin.periode.index'); });

    // Monitoring
    Route::get('/logbook', function () { return view('admin.logbook.index'); });
    Route::get('/absensi', function () { return view('admin.absensi.index'); });

    // Penilaian & Laporan
    Route::get('/penilaian', function () { return view('admin.penilaian.index'); });
    Route::get('/laporan', function () { return view('admin.laporan.index'); });
});

// Pembimbing Routes
Route::prefix('pembimbing')->group(function () {
    Route::get('/', function () {
        return view('pembimbing.dashboard');
    });

    // Peserta Bimbingan
    Route::get('/peserta', function () { return view('pembimbing.peserta.index'); });
    Route::get('/peserta/{id}', function () { return view('pembimbing.peserta.show'); });

    // Penilaian
    Route::get('/penilaian', function () { return view('pembimbing.penilaian.index'); });
    Route::get('/penilaian/{id}', function () { return view('pembimbing.penilaian.edit'); });
    Route::post('/penilaian', function () { return redirect('/pembimbing/penilaian')->with('success', 'Penilaian berhasil disimpan'); });

    // Laporan
    Route::get('/laporan', function () { return view('pembimbing.laporan.index'); });
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->group(function () {
    Route::get('/', function () {
        return view('mahasiswa.dashboard');
    });

    // Logbook
    Route::get('/logbook', function () { return view('mahasiswa.logbook.index'); });
    Route::get('/logbook/create', function () { return view('mahasiswa.logbook.create'); });
    Route::post('/logbook', function () { return redirect('/mahasiswa/logbook')->with('success', 'Logbook berhasil disimpan'); });

    // Absensi
    Route::get('/absensi', function () { return view('mahasiswa.absensi.index'); });
    Route::get('/absensi/create', function () { return view('mahasiswa.absensi.create'); });
    Route::post('/absensi', function () { return redirect('/mahasiswa/absensi')->with('success', 'Absensi berhasil dikirim'); });

    // Placeholders
    Route::get('/profil', function () { return view('placeholder'); });
    Route::get('/magang', function () { return view('placeholder'); });
    Route::get('/nilai', function () { return view('placeholder'); });
});