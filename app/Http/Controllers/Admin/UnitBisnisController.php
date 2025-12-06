<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodeMagang;
use App\Models\UnitBisnis;

class UnitBisnisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = UnitBisnis::orderBy('nama_unit_bisnis', 'asc')->get();
        return view('admin.unit-bisnis.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $periodes = PeriodeMagang::all();
        return view('admin.unit-bisnis.create', compact('periodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_unit_bisnis' => 'required|string|max:255|unique:unit_bisnis,nama_unit_bisnis',
            'id_periode' => 'nullable|exists:periode_magang,id',
        ]);

        UnitBisnis::create($validated);

        return redirect()->route('unit-bisnis.index')->with('success', 'Unit bisnis berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = UnitBisnis::with(['magang', 'absen'])->findOrFail($id);
        return view('admin.unit-bisnis.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit = UnitBisnis::findOrFail($id);
        $periodes = PeriodeMagang::all();
        return view('admin.unit-bisnis.edit', compact('unit', 'periodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = UnitBisnis::findOrFail($id);

        $validated = $request->validate([
            'nama_unit_bisnis' => 'required|string|max:255|unique:unit_bisnis,nama_unit_bisnis,' . $id,
            'id_periode' => 'nullable|exists:periode_magang,id',
        ]);

        $unit->update($validated);

        return redirect()->route('unit-bisnis.index')->with('success', 'Unit bisnis berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = UnitBisnis::findOrFail($id);
        $unit->delete();

        return redirect()->route('unit-bisnis.index')->with('success', 'Unit bisnis berhasil dihapus');
    }
}
