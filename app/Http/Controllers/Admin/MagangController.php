<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\UnitBisnis;
use App\Models\PeriodeMagang;
use App\Models\Dosen;
use Illuminate\Http\Request;

class MagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $magangs = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang', 'dosen'])->get();
        $aktif = $magangs->where('status_magang', 'Aktif');
        $pending = $magangs->where('status_magang', 'Pending');
        $dibatalkan = $magangs->whereIn('status_magang', ['dibatalkan', 'Nonaktif']);
        $selesai = $magangs->where('status_magang', 'selesai');
        return view('admin.magang.index', compact('aktif', 'pending', 'dibatalkan', 'selesai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::with('user')->get();
        $units = UnitBisnis::all();
        $periodes = PeriodeMagang::all();
        $dosens = Dosen::where('status', 'aktif')->get();
        return view('admin.magang.create', compact('mahasiswas', 'units', 'periodes', 'dosens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_mahasiswa' => 'required|exists:mahasiswa,id|unique:magang,id_mahasiswa',
            'unit_id' => 'required|exists:unit_bisnis,id',
            'periode_id' => 'required|exists:periode_magang,id',
            'id_dosen' => 'required|exists:dosen,id',
            'pembimbing_lapangan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tugas_description' => 'required|string',
            'target_book_mingguan' => 'required|integer|min:1',
            'unit_lainnya' => 'nullable|string',
        ]);

        $validated['status_magang'] = 'Aktif';

        Magang::create($validated);

        return redirect()->route('magang.index')->with('success', 'Magang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $magang = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang', 'dosen'])->findOrFail($id);
        return view('admin.magang.show', compact('magang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $magang = Magang::findOrFail($id);
        $mahasiswas = Mahasiswa::with('user')->get();
        $units = UnitBisnis::all();
        $periodes = PeriodeMagang::all();
        $dosens = Dosen::where('status', 'aktif')->get();
        return view('admin.magang.edit', compact('magang', 'mahasiswas', 'units', 'periodes', 'dosens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $magang = Magang::findOrFail($id);

        $validated = $request->validate([
            'id_mahasiswa' => 'required|exists:mahasiswa,id|unique:magang,id_mahasiswa,' . $id,
            'unit_id' => 'required|exists:unit_bisnis,id',
            'periode_id' => 'required|exists:periode_magang,id',
            'id_dosen' => 'required|exists:dosen,id',
            'pembimbing_lapangan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status_magang' => 'required|in:Pending,Aktif,Nonaktif,selesai,dibatalkan',
            'tugas_description' => 'required|string',
            'target_book_mingguan' => 'required|integer|min:1',
            'unit_lainnya' => 'nullable|string',
        ]);

        $magang->update($validated);

        return redirect()->route('magang.index')->with('success', 'Magang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $magang = Magang::findOrFail($id);
        $magang->delete();

        return redirect()->route('magang.index')->with('success', 'Magang berhasil dihapus');
    }

    /**
     * Accept a pending magang application.
     */
    public function terima(string $id)
    {
        $magang = Magang::findOrFail($id);
        $magang->update(['status_magang' => 'Aktif']);

        return redirect()->route('magang.index')->with('success', 'Pendaftaran magang berhasil diterima dan logbook awal dibuat');
    }

    /**
     * Reject a pending magang application.
     */
    public function tolak(string $id)
    {
        $magang = Magang::findOrFail($id);
        $magang->update(['status_magang' => 'dibatalkan']);
        
        return redirect()->route('magang.index')->with('success', 'Pendaftaran magang berhasil ditolak dan pencatatan dibuat');
    }
}
