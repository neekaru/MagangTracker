<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\PeriodeMagang;
use App\Models\UnitBisnis;
use App\Exports\MagangExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $periodes = PeriodeMagang::orderBy('tanggal_mulai', 'desc')->get();
        $units = UnitBisnis::orderBy('nama_unit_bisnis')->get();

        return view('admin.laporan.index', compact('periodes', 'units'));
    }

    public function exportPdf(Request $request)
    {
        $query = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang', 'dosen']);

        // Apply filters
        if ($request->status) {
            $query->where('status_magang', $request->status);
        }

        if ($request->periode_id) {
            $query->where('periode_id', $request->periode_id);
        }

        if ($request->unit_id) {
            $query->where('unit_id', $request->unit_id);
        }

        $magangs = $query->orderBy('created_at', 'desc')->get();

        // Get filter labels
        $filterLabels = [
            'status' => $request->status ?? 'Semua',
            'periode' => $request->periode_id ? PeriodeMagang::find($request->periode_id)->nama_periode : 'Semua',
            'unit' => $request->unit_id ? UnitBisnis::find($request->unit_id)->nama_unit_bisnis : 'Semua',
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('magangs', 'filterLabels'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-magang-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new MagangExport($request->status, $request->periode_id, $request->unit_id),
            'laporan-magang-' . date('Y-m-d') . '.xlsx'
        );
    }
}
