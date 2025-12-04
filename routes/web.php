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
    Route::get('/users', function () {
        return view('admin.users.index');
    });
    Route::get('/users/create', function () {
        return view('admin.users.create');
    });
    Route::post('/users', function () {
        return redirect('/admin/users')->with('success', 'User berhasil ditambahkan');
    });
    Route::get('/users/{id}', function () {
        return view('admin.users.show');
    });
    Route::get('/users/{id}/edit', function () {
        return view('admin.users.edit');
    });
    Route::put('/users/{id}', function () {
        return redirect('/admin/users')->with('success', 'User berhasil diupdate');
    });

    // Magang Management
    Route::get('/magang', function () {
        return view('admin.magang.index');
    });
    Route::get('/magang/{id}', function () {
        return view('admin.magang.show');
    });
    Route::get('/magang/{id}/edit', function () {
        return view('admin.magang.edit');
    });
    Route::put('/magang/{id}', function () {
        return redirect('/admin/magang')->with('success', 'Data magang berhasil diupdate');
    });

    // Periode Magang
    Route::get('/periode-magang', function () {
        return view('admin.periode.index');
    });
    Route::get('/periode-magang/create', function () {
        return view('admin.periode.create');
    });
    Route::post('/periode-magang', function () {
        return redirect('/admin/periode-magang')->with('success', 'Periode berhasil ditambahkan');
    });
    Route::get('/periode-magang/{id}/edit', function () {
        return view('admin.periode.edit');
    });
    Route::put('/periode-magang/{id}', function () {
        return redirect('/admin/periode-magang')->with('success', 'Periode berhasil diupdate');
    });

    // Monitoring
    Route::get('/logbook', function () {
        return view('admin.logbook.index');
    });
    Route::get('/logbook/{id}', function () {
        return view('admin.logbook.show');
    });

    Route::get('/absensi', function () {
        return view('admin.absensi.index');
    });
    Route::get('/absensi/{id}', function () {
        return view('admin.absensi.show');
    });

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
Route::prefix('pembimbing')->group(function () {
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
Route::prefix('mahasiswa')->group(function () {
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
    Route::get('/logbook', function () {
        return view('mahasiswa.logbook.index');
    });
    Route::get('/logbook/create', function () {
        return view('mahasiswa.logbook.create');
    });
    Route::post('/logbook', function () {
        return redirect('/mahasiswa/logbook')->with('success', 'Logbook berhasil disimpan');
    });
    Route::get('/logbook/{id}/edit', function () {
        return view('mahasiswa.logbook.edit');
    });
    Route::put('/logbook/{id}', function () {
        return redirect('/mahasiswa/logbook')->with('success', 'Logbook berhasil diperbarui');
    });

    // Absensi
    Route::get('/absensi', function () {
        return view('mahasiswa.absensi.index');
    });
    Route::get('/absensi/create', function () {
        return view('mahasiswa.absensi.create');
    });
    Route::post('/absensi', function () {
        return redirect('/mahasiswa/absensi')->with('success', 'Absensi berhasil dikirim');
    });

    // Profil
    Route::get('/profil', function () {
        return view('mahasiswa.profil.index');
    });
    Route::put('/profil', function () {
        return redirect('/mahasiswa/profil')->with('success', 'Profil berhasil diperbarui');
    });

    // Info Magang
    Route::get('/magang', function () {
        $deskripsi_tugas = "Sebagai peserta magang di unit IT Support, tugas utama Anda meliputi:\n- Membantu maintenance perangkat keras dan lunak kantor.\n- Melakukan troubleshooting jaringan dasar.\n- Membantu instalasi dan konfigurasi software.\n- Mendokumentasikan kegiatan perbaikan dan maintenance.";
        $pembimbing_lapangan = "Pak Joko (IT Manager)";
        $tgl_mulai = "01 Jan 2025";
        $tgl_selesai = "30 Jun 2025";
        $target_logbook = 5; // Data dari database
        return view('mahasiswa.magang.index', compact('deskripsi_tugas', 'pembimbing_lapangan', 'tgl_mulai', 'tgl_selesai', 'target_logbook'));
    });

    // Nilai
    Route::get('/nilai', function () {
        return view('mahasiswa.nilai.index');
    });
});
