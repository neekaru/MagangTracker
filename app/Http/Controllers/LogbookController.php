<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Magang;
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
            $logbooks = Logbook::all();
            return view('admin.logbook.index', compact('logbooks'));
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

        return redirect()->route('logbook.index')->with('success', 'Logbook created successfully.');
    }

    public function edit(Logbook $logbook)
    {
        $user = Auth::user();
        if ($user->role === 'Mahasiswa') {
            // Ensure logbook belongs to user's magang
            if (!$logbook->magang || $logbook->magang->id_mahasiswa !== $user->mahasiswa->id) {
                abort(403);
            }
            return view('mahasiswa.logbook.edit', compact('logbook'));
        } elseif ($user->role === 'Admin') {
            return view('admin.logbook.edit', compact('logbook'));
        }
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
            return redirect()->route('logbook.index')->with('success', 'Logbook updated successfully.');
        } elseif ($user->role === 'Admin') {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected',
                'approved_by' => 'nullable|exists:users,id',
            ]);
            $logbook->update($request->only(['status', 'approved_by']));
            return redirect()->route('logbook.index')->with('success', 'Logbook updated successfully.');
        } elseif ($user->role === 'Pembimbing') {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected',
            ]);
            // Check if dosen is the pembimbing for this magang
            if ($logbook->magang->id_dosen !== $user->id_dosen) {
                abort(403);
            }
            $logbook->update([
                'status' => $request->status,
                'approved_by' => $user->id,
            ]);
            return redirect()->route('pembimbing.logbook.index')->with('success', 'Logbook status updated successfully.');
        }
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
