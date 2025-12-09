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
            
            if (!$mahasiswa) {
                return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
            }
            
            $absensis = Absen::whereHas('magang', function ($q) use ($mahasiswa) {
                $q->where('id_mahasiswa', $mahasiswa->id);
            })->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();
            return view('mahasiswa.absensi.index', compact('absensis'));
        } elseif ($user->role === 'Admin') {
            $absensis = Absen::with(['magang.mahasiswa', 'unitBisnis'])->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();
            return view('admin.absensi.index', compact('absensis'));
        }
    }

    public function create()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        
        $magangs = Magang::where('id_mahasiswa', $mahasiswa->id)->get();
        
        if ($magangs->isEmpty()) {
            return redirect()->route('mahasiswa.magang.index')->with('error', 'Anda belum terdaftar dalam magang.');
        }
        
        return view('mahasiswa.absensi.create', compact('magangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'magang_id' => 'required|exists:magang,id',
            'jenis_absen' => 'required|in:masuk,pulang',
            'tanggal' => 'required|date',
            'jam' => 'nullable|date_format:H:i',
            'status_kehadiran' => 'required|in:Hadir,Izin,Sakit',
            'keterangan' => 'nullable|string',
        ]);

        // Cek apakah sudah absen untuk jenis yang sama di hari yang sama
        $existingAbsen = Absen::where('magang_id', $request->magang_id)
            ->where('jenis_absen', $request->jenis_absen)
            ->whereDate('tanggal', $request->tanggal)
            ->first();

        if ($existingAbsen) {
            return redirect()->back()->withInput()->with('error', 'Anda sudah melakukan absensi ' . $request->jenis_absen . ' pada tanggal ini.');
        }

        // Auto set id_unit_bisnis from magang
        $magang = Magang::find($request->magang_id);
        $data = $request->all();
        $data['id_unit_bisnis'] = $magang->unit_id;

        Absen::create($data);

        $user = Auth::user();
        if ($user->role === 'Mahasiswa') {
            return redirect()->route('mahasiswa.absensi.index')->with('success', 'Absensi berhasil dicatat.');
        } else {
            return redirect()->route('admin.absensi.index')->with('success', 'Absensi berhasil dicatat.');
        }
    }

    public function show($id)
    {
        $absen = Absen::with(['magang.mahasiswa', 'unitBisnis'])->findOrFail($id);
        return view('admin.absensi.show', compact('absen'));
    }
}
