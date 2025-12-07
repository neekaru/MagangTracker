<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class PenilaianController extends Controller
{
    /**
     * Display a listing of all penilaian
     */
    public function index()
    {
        $penilaianList = Penilaian::with([
            'magang.mahasiswa.user',
            'magang.unitBisnis',
            'penilai'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('admin.penilaian.index', compact('penilaianList'));
    }

    /**
     * Display the specified penilaian
     */
    public function show($id)
    {
        $penilaian = Penilaian::with([
            'magang.mahasiswa.user',
            'magang.unitBisnis',
            'magang.periodeMagang',
            'penilai'
        ])
        ->findOrFail($id);

        // Calculate average nilai
        $rataRata = (
            $penilaian->nilai_kedisplinan +
            $penilaian->nilai_tanggung_jawab +
            $penilaian->nilai_kemampuan_teknis +
            $penilaian->nilai_laporan_akhir +
            $penilaian->nilai_prestasi
        ) / 5;

        return view('admin.penilaian.show', compact('penilaian', 'rataRata'));
    }

    /**
     * Show the form for editing the specified penilaian
     */
    public function edit($id)
    {
        $penilaian = Penilaian::with([
            'magang.mahasiswa.user',
            'magang.unitBisnis',
            'penilai'
        ])
        ->findOrFail($id);

        return view('admin.penilaian.edit', compact('penilaian'));
    }

    /**
     * Update the specified penilaian
     */
    public function update(Request $request, $id)
    {
        $penilaian = Penilaian::findOrFail($id);

        $validated = $request->validate([
            'nilai_kedisplinan' => 'required|integer|min:0|max:100',
            'nilai_tanggung_jawab' => 'required|integer|min:0|max:100',
            'nilai_kemampuan_teknis' => 'required|integer|min:0|max:100',
            'nilai_laporan_akhir' => 'required|integer|min:0|max:100',
            'nilai_prestasi' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        $penilaian->update($validated);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui');
    }

    /**
     * Remove the specified penilaian
     */
    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }
}
