<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['mahasiswa', 'dosen'])->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:Admin,Pembimbing,Mahasiswa',
            'nama_lengkap' => 'required_if:role,Pembimbing,Mahasiswa',
            'nip' => 'nullable|string',
            'nisn' => 'required_if:role,Mahasiswa',
            'tanggal_mulai' => 'required_if:role,Mahasiswa|nullable|date',
            'tanggal_selesai' => 'required_if:role,Mahasiswa|nullable|date',
        ]);

        // Create user first
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Create related record based on role
        if ($validated['role'] === 'Pembimbing') {
            $dosen = Dosen::create([
                'user_id' => $user->id,
                'nama_lengkap' => $validated['nama_lengkap'],
                'nip' => $validated['nip'] ?? null,
            ]);
            $user->update(['id_dosen' => $dosen->id]);
        } elseif ($validated['role'] === 'Mahasiswa') {
            $mahasiswa = Mahasiswa::create([
                'user_id' => $user->id,
                'nisn' => $validated['nisn'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
            ]);
            $user->update(['id_mahasiswa' => $mahasiswa->id]);
        }

        return redirect('/admin/users')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['mahasiswa', 'dosen'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with(['mahasiswa', 'dosen'])->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:Admin,Pembimbing,Mahasiswa',
            'nama_lengkap' => 'required_if:role,Pembimbing,Mahasiswa',
            'nip' => 'nullable|string',
            'nisn' => 'required_if:role,Mahasiswa',
            'tanggal_mulai' => 'required_if:role,Mahasiswa|nullable|date',
            'tanggal_selesai' => 'required_if:role,Mahasiswa|nullable|date',
        ]);

        // Update user
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->role = $validated['role'];
        $user->save();

        // Update or create related record based on role
        if ($validated['role'] === 'Pembimbing') {
            if ($user->dosen) {
                $user->dosen->update([
                    'nama_lengkap' => $validated['nama_lengkap'],
                    'nip' => $validated['nip'] ?? null,
                ]);
            } else {
                $dosen = Dosen::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $validated['nama_lengkap'],
                    'nip' => $validated['nip'] ?? null,
                ]);
                $user->update(['id_dosen' => $dosen->id]);
            }
        } elseif ($validated['role'] === 'Mahasiswa') {
            if ($user->mahasiswa) {
                $user->mahasiswa->update([
                    'nisn' => $validated['nisn'],
                    'nama_lengkap' => $validated['nama_lengkap'],
                    'tanggal_mulai' => $validated['tanggal_mulai'],
                    'tanggal_selesai' => $validated['tanggal_selesai'],
                ]);
            } else {
                $mahasiswa = Mahasiswa::create([
                    'user_id' => $user->id,
                    'nisn' => $validated['nisn'],
                    'nama_lengkap' => $validated['nama_lengkap'],
                    'tanggal_mulai' => $validated['tanggal_mulai'],
                    'tanggal_selesai' => $validated['tanggal_selesai'],
                ]);
                $user->update(['id_mahasiswa' => $mahasiswa->id]);
            }
        }

        return redirect('/admin/users')->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Delete related records first
        if ($user->mahasiswa) {
            $user->mahasiswa->delete();
        }
        if ($user->dosen) {
            $user->dosen->delete();
        }

        $user->delete();

        return redirect('/admin/users')->with('success', 'User berhasil dihapus');
    }
}
