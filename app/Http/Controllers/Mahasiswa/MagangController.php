<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $magang = Magang::where('id_mahasiswa', $mahasiswa->id)->first();

        if ($magang) {
            $deskripsi_tugas = $magang->tugas_description;
            $pembimbing_lapangan = $magang->pembimbing_lapangan;
            $tgl_mulai = $magang->tanggal_mulai->format('d M Y');
            $tgl_selesai = $magang->tanggal_selesai->format('d M Y');
            $target_logbook = $magang->target_book_mingguan;
            $status_magang = $magang->status_magang;
            $unit_penempatan = $magang->unitBisnis->nama_unit_bisnis ?? 'N/A';
            $periode = $magang->periodeMagang->nama_periode ?? 'N/A';
            $dosen = $magang->dosen->nama_lengkap ?? 'N/A';
            $has_magang = true;
        } else {
            $deskripsi_tugas = null;
            $pembimbing_lapangan = null;
            $tgl_mulai = null;
            $tgl_selesai = null;
            $target_logbook = null;
            $status_magang = null;
            $unit_penempatan = null;
            $periode = null;
            $dosen = null;
            $has_magang = false;
        }

        return view('mahasiswa.magang.index', compact(
            'deskripsi_tugas',
            'pembimbing_lapangan',
            'tgl_mulai',
            'tgl_selesai',
            'target_logbook',
            'status_magang',
            'unit_penempatan',
            'periode',
            'dosen',
            'has_magang'
        ));
    }
}
