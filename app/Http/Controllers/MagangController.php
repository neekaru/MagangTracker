<?php

namespace App\Http\Controllers;

use App\Models\Magang;
use App\Models\UnitBisnis;
use App\Models\PeriodeMagang;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagangController extends Controller
{
    // Mahasiswa: Create, Store
    public function create()
    {
        // Pendaftaran magang oleh mahasiswa dinonaktifkan.
        return redirect()->route('mahasiswa.magang.index')
            ->with('info', 'Pendaftaran magang dinonaktifkan. Silakan hubungi Admin untuk mendaftar.');
    }

    public function store(Request $request)
    {
        // Prevent storing magang through mahasiswa controller as registration is admin-only.
        return redirect()->route('mahasiswa.magang.index')
            ->with('error', 'Pendaftaran magang melalui aplikasi dinonaktifkan. Silakan hubungi Admin.');
    }
}
