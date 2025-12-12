<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Logbook;
use App\Models\Magang;
use App\Models\PeriodeMagang;
use App\Models\UnitBisnis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    // Mahasiswa: Index, Create, Store, Edit, Update
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'Mahasiswa') {
            $mahasiswa = $user->mahasiswa;
            $logbooks = Logbook::whereHas('magang', function ($q) use ($mahasiswa) {
                $q->where('id_mahasiswa', $mahasiswa->id);
            })->get();
            return view('mahasiswa.logbook.index', compact('logbooks'));
        } elseif ($user->role === 'Admin') {
            $selectedPeriodeId = request('periode_id');
            $selectedUnitId = request('unit_id');

            $logbooksQuery = Logbook::with(['magang.mahasiswa', 'magang.unitBisnis', 'magang.periodeMagang']);

            if ($selectedPeriodeId) {
                $logbooksQuery->whereHas('magang', function ($q) use ($selectedPeriodeId) {
                    $q->where('periode_id', $selectedPeriodeId);
                });
            }

            if ($selectedUnitId) {
                $logbooksQuery->whereHas('magang', function ($q) use ($selectedUnitId) {
                    $q->where('unit_id', $selectedUnitId);
                });
            }

            $logbooks = $logbooksQuery->get();
            $periodes = PeriodeMagang::orderBy('nama_periode')->get();
            $units = UnitBisnis::orderBy('nama_unit_bisnis')->get();

            return view('admin.logbook.index', compact(
                'logbooks',
                'periodes',
                'units',
                'selectedPeriodeId',
                'selectedUnitId'
            ));
        }
    }

    public function create()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $magangs = Magang::where('id_mahasiswa', $mahasiswa->id)->get();
        return view('mahasiswa.logbook.create', compact('magangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'magang_id' => 'required|exists:magang,id',
            'tanggal_logbook' => 'required|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'deskripsi_kegiatan' => 'required|string',
            'hasil_kegiatan' => 'nullable|string',
            'foto_kegiatan' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto_kegiatan')) {
            $data['foto_kegiatan'] = $request->file('foto_kegiatan')->store('logbook_photos', 'public');
        }

        Logbook::create($data);

        return redirect()->route('mahasiswa.logbook.index')->with('success', 'Logbook created successfully.');
    }

    public function show(Logbook $logbook)
    {
        $user = Auth::user();
        if ($user->role === 'Pembimbing') {
            if (!$logbook->magang || $logbook->magang->id_dosen !== optional($user->dosen)->id) {
                abort(403, 'Unauthorized action.');
            }
            return view('pembimbing.logbook.show', compact('logbook'));
        } elseif ($user->role === 'Admin') {
            // Admin can view all logbooks
            return view('admin.logbook.show', compact('logbook'));
        }

        abort(403, 'Unauthorized action.');
    }

    public function edit(Logbook $logbook)
    {
        $user = Auth::user();
        if ($user->role === 'Mahasiswa') {
            // Ensure logbook belongs to user's magang
            if (!$logbook->magang || $logbook->magang->id_mahasiswa !== $user->mahasiswa->id) {
                abort(403, 'Unauthorized action.');
            }
            return view('mahasiswa.logbook.edit', compact('logbook'));
        }

        abort(403, 'Unauthorized action.');
    }

    public function update(Request $request, Logbook $logbook)
    {
        $user = Auth::user();
        if ($user->role === 'Mahasiswa') {
            $request->validate([
                'tanggal_logbook' => 'required|date',
                'jam_mulai' => 'nullable|date_format:H:i',
                'jam_selesai' => 'nullable|date_format:H:i',
                'deskripsi_kegiatan' => 'required|string',
                'hasil_kegiatan' => 'nullable|string',
                'foto_kegiatan' => 'nullable|image|max:2048',
            ]);
            $data = $request->only(['tanggal_logbook', 'jam_mulai', 'jam_selesai', 'deskripsi_kegiatan', 'hasil_kegiatan']);
            if ($request->hasFile('foto_kegiatan')) {
                $data['foto_kegiatan'] = $request->file('foto_kegiatan')->store('logbook_photos', 'public');
            }
            $logbook->update($data);
            return redirect()->route('mahasiswa.logbook.index')->with('success', 'Logbook updated successfully.');
        } elseif ($user->role === 'Pembimbing') {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected',
            ]);
            // Check if dosen is the pembimbing for this magang
            if ($logbook->magang->id_dosen !== $user->id_dosen) {
                abort(403, 'Unauthorized action.');
            }
            $logbook->update([
                'status' => $request->status,
                'approved_by' => $user->id,
            ]);
            return redirect()->route('pembimbing.logbook.index')->with('success', 'Logbook status updated successfully.');
        }

        abort(403, 'Unauthorized action.');
    }

    public function destroy(Logbook $logbook)
    {
        $user = Auth::user();
        if ($user->role !== 'Admin') {
            abort(403);
        }
        $logbook->delete();
        return redirect()->route('logbook.index')->with('success', 'Logbook deleted successfully.');
    }

    // Pembimbing: Index for update status
    public function pembimbingIndex()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        $logbooks = Logbook::whereHas('magang', function ($q) use ($dosen) {
            $q->where('id_dosen', $dosen->id);
        })->get();
        return view('pembimbing.logbook.index', compact('logbooks'));
    }
}
