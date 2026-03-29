<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        // Get all magang where this dosen is pembimbing
        $pesertas = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang'])
            ->where('dosen_pembimbing_id', $dosen->id)
            ->get();
        
        return view('pembimbing.peserta.index', compact('pesertas'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        // Get magang detail with all relations, ensure dosen ownership
        $peserta = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang', 'dosen', 'logbook', 'absen'])
            ->where('dosen_pembimbing_id', $dosen->id)
            ->findOrFail($id);
        
        return view('pembimbing.peserta.show', compact('peserta'));
    }
}
