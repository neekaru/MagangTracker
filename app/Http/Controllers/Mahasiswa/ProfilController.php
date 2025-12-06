<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        
        return view('mahasiswa.profil.index', compact('user', 'mahasiswa'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nisn' => 'required|string|unique:mahasiswa,nisn,' . $mahasiswa->id,
            'nama_lengkap' => 'required|string',
            'password' => 'nullable|min:6|confirmed',
        ]);
        
        // Update user
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        
        // Update mahasiswa
        $mahasiswa->nisn = $request->nisn;
        $mahasiswa->nama_lengkap = $request->nama_lengkap;
        $mahasiswa->save();
        
        return redirect()->route('mahasiswa.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
