<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // Mahasiswa: Index (Read), Create, Store
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'Mahasiswa') {
            $mahasiswa = $user->mahasiswa;
            $absensis = Absen::whereHas('magang', function ($q) use ($mahasiswa) {
                $q->where('id_mahasiswa', $mahasiswa->id);
            })->get();
            return view('mahasiswa.absensi.index', compact('absensis'));
        } elseif ($user->role === 'Admin') {
            $absensis = Absen::all();
            return view('admin.absensi.index', compact('absensis'));
        }
    }

    public function create()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $magangs = Magang::where('id_mahasiswa', $mahasiswa->id)->get();
        return view('mahasiswa.absensi.create', compact('magangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'magang_id' => 'required|exists:magang,id',
            'tanggal' => 'required|date',
            'jam' => 'nullable|date_format:H:i',
            'status_kehadiran' => 'required|in:Hadir,Izin,Sakit',
            'keterangan' => 'nullable|string',
        ]);

        // Auto set id_unit_bisnis from magang
        $magang = Magang::find($request->magang_id);
        $data = $request->all();
        $data['id_unit_bisnis'] = $magang->unit_id;

        Absen::create($data);

        return redirect()->route('absensi.index')->with('success', 'Absensi recorded successfully.');
    }
}
