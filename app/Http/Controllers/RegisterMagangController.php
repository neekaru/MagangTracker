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
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        
        // Check if already registered
        $existingMagang = Magang::where('id_mahasiswa', $mahasiswa->id)->first();
        if ($existingMagang) {
            return redirect()->route('mahasiswa.magang.index')->with('info', 'Anda sudah terdaftar magang.');
        }
        
        $unitBisnis = UnitBisnis::all();
        $periodeMagang = PeriodeMagang::all();
        $dosens = \App\Models\Dosen::all();
                
        return view('auth.register-magang', compact('mahasiswa', 'unitBisnis', 'periodeMagang', 'dosens'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        
        // Check if already registered
        $existingMagang = Magang::where('id_mahasiswa', $mahasiswa->id)->first();
        if ($existingMagang) {
            return redirect()->route('mahasiswa.magang.index')->with('info', 'Anda sudah terdaftar magang.');
        }
        
        $validated = $request->validate([
            'id_unit_bisnis' => 'required|exists:unit_bisnis,id',
            'id_periode_magang' => 'required|exists:periode_magang,id',
            'id_dosen' => 'required|exists:dosen,id',
            'pembimbing_lapangan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);
        
        Magang::create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $validated['id_unit_bisnis'],
            'periode_id' => $validated['id_periode_magang'],
            'id_dosen' => $validated['id_dosen'],
            'pembimbing_lapangan' => $validated['pembimbing_lapangan'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status_magang' => 'Pending',
            'tugas_description' => '',
            'target_book_mingguan' => 5,
            'unit_lainnya' => null,
        ]);
        
        return redirect()->route('mahasiswa.magang.index')->with('success', 'Pendaftaran magang berhasil diajukan.');
    }
}
