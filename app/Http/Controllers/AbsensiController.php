<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
                $q->where('mahasiswa_id', $mahasiswa->id);
            })->with(['magang.unitBisnis'])->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();
            return view('mahasiswa.absensi.index', compact('absensis'));
        } elseif ($user->role === 'Admin') {
            $absensis = Absen::with(['magang.mahasiswa', 'magang.unitBisnis', 'validator'])
                ->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();
            return view('admin.absensi.index', compact('absensis'));
        } elseif ($user->role === 'Pembimbing') {
            $dosen = $user->dosen;
            if (!$dosen) {
                return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
            }

            $absensis = Absen::with(['magang.mahasiswa', 'magang.unitBisnis'])
                ->whereHas('magang', function ($q) use ($dosen) {
                    $q->where('dosen_pembimbing_id', $dosen->id);
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

            $magangs = Magang::where('mahasiswa_id', $mahasiswa->id)->get();

            if ($magangs->isEmpty()) {
                return redirect()->route('mahasiswa.magang.index')
                    ->with('error', 'Anda belum terdaftar dalam magang.');
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

        $request->validate([
            'magang_id' => 'required|exists:magang,id',
            'jenis_absen' => 'nullable|in:masuk,pulang',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status_kehadiran' => 'required|in:Hadir,Izin,Sakit',
            'keterangan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $jenisAbsen = $request->input('jenis_absen');
        $statusKehadiran = $request->input('status_kehadiran');

        // Jika status bukan Hadir, jenis_absen tidak diperlukan
        if ($statusKehadiran !== 'Hadir') {
            $jenisAbsen = null;
        } else {
            if (empty($jenisAbsen)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Jenis absensi wajib diisi untuk status Hadir.');
            }
        }

        $serverNow = now();
        $tanggalServer = $serverNow->toDateString();

        // Cek duplikasi absensi untuk hari yang sama (berdasarkan tanggal server)
        if ($statusKehadiran === 'Hadir' && $jenisAbsen) {
            $exists = Absen::where('magang_id', $request->magang_id)
                ->where('jenis_absen', $jenisAbsen)
                ->whereDate('tanggal', $tanggalServer)
                ->exists();

            if ($exists) {
                return redirect()->back()->withInput()
                    ->with('error', 'Anda sudah melakukan absensi ' . $jenisAbsen . ' pada tanggal ini.');
            }
        }

        // Upload foto bukti ke storage/app/public/absensi/foto
        $fotoBuktiPath = null;
        if ($request->hasFile('foto_bukti') && $request->file('foto_bukti')->isValid()) {
            $fotoBuktiPath = $request->file('foto_bukti')->store('absensi/foto', 'public');
        }

        Absen::create([
            'magang_id' => $request->magang_id,
            'jenis_absen' => $jenisAbsen,
            'tanggal' => $serverNow->toDateString(),
            'jam' => $serverNow->format('H:i'),
            'latitude' => $request->latitude ?? null,
            'longitude' => $request->longitude ?? null,
            'status_kehadiran' => $statusKehadiran,
            'keterangan' => $request->keterangan ?? null,
            'foto_bukti' => $fotoBuktiPath,
            'status_validasi' => 'pending',
            'validasi_by' => null,
            'validated_at' => null,
        ]);

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
            if (!$dosen || !$absensi->magang || $absensi->magang->dosen_pembimbing_id !== $dosen->id) {
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
            return redirect()->route('pembimbing.absensi.index')
                ->with('error', 'Validasi absensi mengikuti approval logbook. Ubah status pada logbook harian peserta.');
        }

        abort(403, 'Unauthorized action.');
    }

    public function destroy(Absen $absensi)
    {
        $user = Auth::user();
        if ($user->role !== 'Admin') {
            abort(403);
        }

        // Hapus file foto dari storage saat data absensi dihapus
        if ($absensi->foto_bukti && Storage::disk('public')->exists($absensi->foto_bukti)) {
            Storage::disk('public')->delete($absensi->foto_bukti);
        }

        $absensi->delete();

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }
}
