<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Magang;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    /**
     * Display a listing of penilaian for students under this pembimbing
     */
    public function index()
    {
        // Get pembimbing's dosen record
        $dosen = Auth::user()->dosen;
        
        if (!$dosen) {
            return redirect()->route('pembimbing.dashboard')->with('error', 'Data pembimbing tidak ditemukan');
        }

        // Get all magang records where this dosen is the pembimbing
        $magangList = Magang::where('id_dosen', $dosen->id)
            ->with(['mahasiswa.user', 'unitBisnis'])
            ->get();

        // Get penilaian for these magang records
        $penilaianList = Penilaian::whereIn('magang_id', $magangList->pluck('id'))
            ->with(['magang.mahasiswa.user', 'magang.unitBisnis'])
            ->get();

        return view('pembimbing.penilaian.index', compact('penilaianList', 'magangList'));
    }

    /**
     * Show the form for creating a new penilaian
     */
    public function create($magangId)
    {
        $magang = Magang::with(['mahasiswa.user', 'unitBisnis', 'dosen'])
            ->findOrFail($magangId);

        // Verify this pembimbing is assigned to this magang
        $dosen = Auth::user()->dosen;
        if ($magang->id_dosen != $dosen->id) {
            return redirect()->route('pembimbing.penilaian.index')
                ->with('error', 'Anda tidak memiliki akses untuk menilai mahasiswa ini');
        }

        // Check if penilaian already exists
        $existingPenilaian = Penilaian::where('magang_id', $magangId)->first();
        if ($existingPenilaian) {
            return redirect()->route('pembimbing.penilaian.edit', $existingPenilaian->id)
                ->with('info', 'Penilaian sudah ada, silakan edit');
        }

        return view('pembimbing.penilaian.create', compact('magang'));
    }

    /**
     * Store a newly created penilaian
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'magang_id' => 'required|exists:magang,id',
            'nilai_kedisplinan' => 'required|integer|min:0|max:100',
            'nilai_tanggung_jawab' => 'required|integer|min:0|max:100',
            'nilai_kemampuan_teknis' => 'required|integer|min:0|max:100',
            'nilai_laporan_akhir' => 'required|integer|min:0|max:100',
            'nilai_prestasi' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        $magang = Magang::findOrFail($validated['magang_id']);
        $dosen = Auth::user()->dosen;

        // Verify pembimbing
        if ($magang->id_dosen != $dosen->id) {
            return redirect()->route('pembimbing.penilaian.index')
                ->with('error', 'Anda tidak memiliki akses untuk menilai mahasiswa ini');
        }

        $validated['mahasiswa_id'] = $magang->id_mahasiswa;
        $validated['dinilai_oleh_id'] = $dosen->id;

        Penilaian::create($validated);

        return redirect()->route('pembimbing.penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan');
    }

    /**
     * Show the form for editing the specified penilaian
     */
    public function edit($id)
    {
        $penilaian = Penilaian::with(['magang.mahasiswa.user', 'magang.unitBisnis', 'magang.dosen'])
            ->findOrFail($id);

        $dosen = Auth::user()->dosen;

        // Verify this pembimbing created this penilaian
        if ($penilaian->dinilai_oleh_id != $dosen->id) {
            return redirect()->route('pembimbing.penilaian.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit penilaian ini');
        }

        return view('pembimbing.penilaian.edit', compact('penilaian'));
    }

    /**
     * Update the specified penilaian
     */
    public function update(Request $request, $id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $dosen = Auth::user()->dosen;

        // Verify access
        if ($penilaian->dinilai_oleh_id != $dosen->id) {
            return redirect()->route('pembimbing.penilaian.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit penilaian ini');
        }

        $validated = $request->validate([
            'nilai_kedisplinan' => 'required|integer|min:0|max:100',
            'nilai_tanggung_jawab' => 'required|integer|min:0|max:100',
            'nilai_kemampuan_teknis' => 'required|integer|min:0|max:100',
            'nilai_laporan_akhir' => 'required|integer|min:0|max:100',
            'nilai_prestasi' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        $penilaian->update($validated);

        return redirect()->route('pembimbing.penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui');
    }

    /**
     * Display the specified penilaian
     */
    public function show($id)
    {
        $penilaian = Penilaian::with(['magang.mahasiswa.user', 'magang.unitBisnis', 'penilai'])
            ->findOrFail($id);

        $dosen = Auth::user()->dosen;

        // Verify this pembimbing has access
        if ($penilaian->dinilai_oleh_id != $dosen->id) {
            return redirect()->route('pembimbing.penilaian.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat penilaian ini');
        }

        return view('pembimbing.penilaian.show', compact('penilaian'));
    }
}
