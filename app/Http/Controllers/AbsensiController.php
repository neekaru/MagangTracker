<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
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
            })->with(['unitBisnis', 'magang'])->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();
            return view('mahasiswa.absensi.index', compact('absensis'));
        } elseif ($user->role === 'Admin') {
            $absensis = Absen::with(['magang.mahasiswa', 'unitBisnis', 'validator'])->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();
            return view('admin.absensi.index', compact('absensis'));
        } elseif ($user->role === 'Pembimbing') {
            $dosen = $user->dosen;
            if (!$dosen) {
                return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
            }

            $absensis = Absen::with(['magang.mahasiswa', 'unitBisnis'])
                ->whereHas('magang', function ($q) use ($dosen) {
                    $q->where('id_dosen', $dosen->id);
                })
                ->orderBy('tanggal', 'desc')
                ->orderBy('jenis_absen', 'asc')
                ->get();

            return view('pembimbing.absensi.index', compact('absensis'));
        }

        abort(403);
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role === 'Mahasiswa') {
            $mahasiswa = $user->mahasiswa;
            
            if (!$mahasiswa) {
                return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
            }
            
            $magangs = Magang::where('id_mahasiswa', $mahasiswa->id)->get();
            
            if ($magangs->isEmpty()) {
                return redirect()->route('mahasiswa.magang.index')->with('error', 'Anda belum terdaftar dalam magang.');
            }
            
            return view('mahasiswa.absensi.create', compact('magangs'));
        } elseif ($user->role === 'Admin') {
            $magangs = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang'])->get();
            return view('admin.absensi.create', compact('magangs'));
        }

        abort(403);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'Admin';

        if (!in_array($user->role, ['Mahasiswa', 'Admin'])) {
            abort(403);
        }

        $rules = [
            'magang_id' => 'required|exists:magang,id',
            'jenis_absen' => 'required|in:masuk,pulang',
            'tanggal' => 'required|date',
            'jam' => 'nullable|date_format:H:i',
            'status_kehadiran' => 'required|in:Hadir,Izin,Sakit',
            'keterangan' => 'nullable|string',
        ];

        if ($isAdmin) {
            $rules['status_validasi'] = 'required|in:pending,approved,rejected';
        }

        $validated = $request->validate($rules);

        // Cek apakah sudah absen untuk jenis yang sama di hari yang sama
        $existingAbsen = Absen::where('magang_id', $validated['magang_id'])
            ->where('jenis_absen', $validated['jenis_absen'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->first();

        if ($existingAbsen) {
            return redirect()->back()->withInput()->with('error', 'Anda sudah melakukan absensi ' . $validated['jenis_absen'] . ' pada tanggal ini.');
        }

        // Auto set id_unit_bisnis from magang
        $magang = Magang::find($validated['magang_id']);
        if (!$magang) {
            return redirect()->back()->withInput()->with('error', 'Data magang tidak ditemukan.');
        }
        $data = $validated;
        $data['id_unit_bisnis'] = $magang->unit_id;
        $data['status_validasi'] = $isAdmin ? $validated['status_validasi'] : 'pending';

        if (!$isAdmin || $data['status_validasi'] === 'pending') {
            $data['validated_by'] = null;
            $data['validated_at'] = null;
        }

        Absen::create($data);

        return redirect()->route($isAdmin ? 'admin.absensi.index' : 'mahasiswa.absensi.index')
            ->with('success', 'Absensi berhasil dicatat.');
    }

    public function show(Absen $absensi)
    {
        $user = Auth::user();
        
        if ($user->role === 'Admin') {
            $absensi->load(['magang.mahasiswa', 'unitBisnis', 'validator']);
            return view('admin.absensi.show', ['absen' => $absensi]);
        } elseif ($user->role === 'Pembimbing') {
            $dosen = $user->dosen;
            if (!$dosen || !$absensi->magang || $absensi->magang->id_dosen !== $dosen->id) {
                abort(403);
            }
            $absensi->load(['magang.mahasiswa', 'unitBisnis']);
            return view('pembimbing.absensi.show', ['absen' => $absensi]);
        }

        abort(403);
    }

    public function edit(Absen $absensi)
    {
        $user = Auth::user();
        if ($user->role !== 'Admin') {
            abort(403);
        }

        $magangs = Magang::with(['mahasiswa', 'unitBisnis'])->get();
        return view('admin.absensi.edit', compact('absensi', 'magangs'));
    }

    public function update(Request $request, Absen $absensi)
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            $validated = $request->validate([
                'magang_id' => 'required|exists:magang,id',
                'jenis_absen' => 'required|in:masuk,pulang',
                'tanggal' => 'required|date',
                'jam' => 'nullable|date_format:H:i',
                'status_kehadiran' => 'required|in:Hadir,Izin,Sakit',
                'status_validasi' => 'required|in:pending,approved,rejected',
                'keterangan' => 'nullable|string',
            ]);

            $magang = Magang::find($validated['magang_id']);
            if (!$magang) {
                return redirect()->back()->withInput()->with('error', 'Data magang tidak ditemukan.');
            }
            $data = $validated;
            $data['id_unit_bisnis'] = $magang->unit_id;

            if ($validated['status_validasi'] === 'pending') {
                $data['validated_by'] = null;
                $data['validated_at'] = null;
            }

            $absensi->update($data);

            return redirect()->route('admin.absensi.index')->with('success', 'Absensi berhasil diperbarui.');
        } elseif ($user->role === 'Pembimbing') {
            $validated = $request->validate([
                'status_validasi' => 'required|in:pending,approved,rejected',
            ]);

            $dosen = $user->dosen;
            if (!$dosen || !$absensi->magang || $absensi->magang->id_dosen !== $dosen->id) {
                abort(403);
            }

            $updateData = [
                'status_validasi' => $validated['status_validasi'],
            ];

            if ($validated['status_validasi'] === 'pending') {
                $updateData['validated_by'] = null;
                $updateData['validated_at'] = null;
            } else {
                $updateData['validated_by'] = $dosen->id;
                $updateData['validated_at'] = now();
            }

            $absensi->update($updateData);

            return redirect()->route('pembimbing.absensi.index')->with('success', 'Status absensi berhasil diperbarui.');
        }

        abort(403);
    }

    public function destroy(Absen $absensi)
    {
        $user = Auth::user();
        if ($user->role !== 'Admin') {
            abort(403);
        }

        $absensi->delete();

        return redirect()->route('admin.absensi.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}
