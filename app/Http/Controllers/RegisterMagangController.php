<?php

namespace App\Http\Controllers;

use App\Models\UnitBisnis;
use App\Models\PeriodeMagang;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterMagangController extends Controller
{
    public function showForm()
    {
        // Pendaftaran magang oleh mahasiswa telah dinonaktifkan.
        // Redirect kembali ke halaman informasi magang dengan pesan instruksi.
        return redirect()->route('mahasiswa.magang.index')
            ->with('info', 'Pendaftaran magang dinonaktifkan. Silakan hubungi Admin untuk mendaftar.');
    }

    public function store(Request $request)
    {
        // Prevent creating magang via this endpoint. Keep defense-in-depth.
        return redirect()->route('mahasiswa.magang.index')
            ->with('error', 'Pendaftaran magang melalui aplikasi dinonaktifkan. Silakan hubungi Admin.');
    }
}
