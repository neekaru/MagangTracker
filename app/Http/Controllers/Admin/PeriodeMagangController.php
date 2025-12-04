<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodeMagang;

class PeriodeMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodes = PeriodeMagang::orderBy('created_at', 'desc')->get();
        return view('admin.periode.index', compact('periodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.periode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status_magang' => 'required|in:Aktif,Nonaktif',
        ]);

        PeriodeMagang::create($validated);

        return redirect()->route('periode-magang.index')->with('success', 'Periode magang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $periode = PeriodeMagang::findOrFail($id);
        return view('admin.periode.show', compact('periode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $periode = PeriodeMagang::findOrFail($id);
        return view('admin.periode.edit', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $periode = PeriodeMagang::findOrFail($id);

        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status_magang' => 'required|in:Aktif,Nonaktif',
        ]);

        $periode->update($validated);

        return redirect()->route('periode-magang.index')->with('success', 'Periode magang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periode = PeriodeMagang::findOrFail($id);
        $periode->delete();

        return redirect()->route('periode-magang.index')->with('success', 'Periode magang berhasil dihapus');
    }
}
