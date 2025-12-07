<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    /**
     * Display the student's assessment (nilai)
     */
    public function index()
    {
        // Get mahasiswa record for the authenticated user
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Data mahasiswa tidak ditemukan');
        }

        // Get penilaian for this mahasiswa
        $penilaian = Penilaian::where('mahasiswa_id', $mahasiswa->id)
            ->with([
                'magang.unitBisnis',
                'magang.periodeMagang',
                'penilai'
            ])
            ->first();

        // Calculate average if penilaian exists
        $rataRata = null;
        if ($penilaian) {
            $rataRata = (
                $penilaian->nilai_kedisplinan +
                $penilaian->nilai_tanggung_jawab +
                $penilaian->nilai_kemampuan_teknis +
                $penilaian->nilai_laporan_akhir +
                $penilaian->nilai_prestasi
            ) / 5;
        }

        // Get magang info
        $magang = Magang::where('id_mahasiswa', $mahasiswa->id)
            ->with(['unitBisnis', 'periodeMagang', 'dosen'])
            ->first();

        return view('mahasiswa.nilai.index', compact('penilaian', 'rataRata', 'magang'));
    }
}
