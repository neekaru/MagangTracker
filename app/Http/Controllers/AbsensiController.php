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
            })->with(['magang.unitBisnis'])->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();
            return view('mahasiswa.absensi.index', compact('absensis'));
        } elseif ($user->role === 'Admin') {
            $absensis = Absen::with(['magang.mahasiswa', 'magang.unitBisnis', 'validator'])->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();
            return view('admin.absensi.index', compact('absensis'));
        } elseif ($user->role === 'Pembimbing') {
            $dosen = $user->dosen;
            if (!$dosen) {
                return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
            }

            $absensis = Absen::with(['magang.mahasiswa', 'magang.unitBisnis'])
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
        }

        abort(403, 'Unauthorized action.');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'Mahasiswa') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'magang_id' => 'required|exists:magang,id',
            'jenis_absen' => 'nullable|in:masuk,pulang',
            'tanggal' => 'required|date',
            'jam' => 'nullable|date_format:H:i',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status_kehadiran' => 'required|in:Hadir,Izin,Sakit',
            'keterangan' => 'nullable|string',
        ]);

        // Jika status bukan Hadir, set jenis_absen ke null
        if ($validated['status_kehadiran'] !== 'Hadir') {
            $validated['jenis_absen'] = null;
        } else {
            // Jika Hadir, jenis_absen wajib diisi
            if (empty($validated['jenis_absen'])) {
                return redirect()->back()->withInput()->with('error', 'Jenis absensi wajib diisi untuk status Hadir.');
            }
        }

        // Cek apakah sudah absen untuk jenis yang sama di hari yang sama (hanya untuk Hadir)
        if ($validated['status_kehadiran'] === 'Hadir' && $validated['jenis_absen']) {
            $existingAbsen = Absen::where('magang_id', $validated['magang_id'])
                ->where('jenis_absen', $validated['jenis_absen'])
                ->whereDate('tanggal', $validated['tanggal'])
                ->first();

            if ($existingAbsen) {
                return redirect()->back()->withInput()->with('error', 'Anda sudah melakukan absensi ' . $validated['jenis_absen'] . ' pada tanggal ini.');
            }
        }

        $data = $validated;
        $data['status_validasi'] = 'pending';
        $data['validated_by'] = null;
        $data['validated_at'] = null;

        Absen::create($data);

        return redirect()->route('mahasiswa.absensi.index')
            ->with('success', 'Absensi berhasil dicatat.');
    }

    public function show(Absen $absensi)
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            $absensi->load(['magang.mahasiswa', 'magang.unitBisnis', 'validator']);
            return view('admin.absensi.show', ['absen' => $absensi]);
        } elseif ($user->role === 'Pembimbing') {
            $dosen = $user->dosen;
            if (!$dosen || !$absensi->magang || $absensi->magang->id_dosen !== $dosen->id) {
                abort(403);
            }
            $absensi->load(['magang.mahasiswa', 'magang.unitBisnis']);
            return view('pembimbing.absensi.show', ['absen' => $absensi]);
        }

        abort(403);
    }


    public function update(Request $request, Absen $absensi)
    {
        $user = Auth::user();

        if ($user->role === 'Pembimbing') {
            $validated = $request->validate([
                'status_validasi' => 'required|in:pending,approved,rejected',
            ]);

            $dosen = $user->dosen;
            if (!$dosen || !$absensi->magang || $absensi->magang->id_dosen !== $dosen->id) {
                abort(403, 'Unauthorized action.');
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

        abort(403, 'Unauthorized action.');
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

