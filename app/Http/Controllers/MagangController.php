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
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Check if already has magang
        if (Magang::where('id_mahasiswa', $mahasiswa->id)->exists()) {
            return redirect()->route('mahasiswa.magang.index')->with('error', 'Anda sudah terdaftar magang.');
        }

        $periodes = PeriodeMagang::where('status_magang', 'Aktif')->get();
        $units = UnitBisnis::all(); // Or filter by periode if needed
        $dosens = Dosen::where('status', 'aktif')->get();

        return view('mahasiswa.magang.create', compact('periodes', 'units', 'dosens'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Check if already has magang
        if (Magang::where('id_mahasiswa', $mahasiswa->id)->exists()) {
            return redirect()->route('mahasiswa.magang.index')->with('error', 'Anda sudah terdaftar magang.');
        }

        $request->validate([
            'periode_id' => 'required|exists:periode_magang,id',
            'unit_id' => 'required|exists:unit_bisnis,id',
            'id_dosen' => 'required|exists:dosen,id',
            'pembimbing_lapangan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tugas_description' => 'required|string',
            'target_book_mingguan' => 'required|integer|min:1',
            'unit_lainnya' => 'nullable|string',
        ]);

        Magang::create([
            'id_mahasiswa' => $mahasiswa->id,
            'periode_id' => $request->periode_id,
            'unit_id' => $request->unit_id,
            'id_dosen' => $request->id_dosen,
            'pembimbing_lapangan' => $request->pembimbing_lapangan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_magang' => 'Aktif',
            'tugas_description' => $request->tugas_description,
            'target_book_mingguan' => $request->target_book_mingguan,
            'unit_lainnya' => $request->unit_lainnya,
        ]);

        return redirect()->route('mahasiswa.magang.index')->with('success', 'Pendaftaran magang berhasil.');
    }
}
