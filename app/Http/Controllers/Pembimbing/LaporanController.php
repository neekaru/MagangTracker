<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\PeriodeMagang;
use App\Models\Dosen;
use App\Exports\MagangExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();
        $periodes = PeriodeMagang::orderBy('tanggal_mulai', 'desc')->get();

        return view('pembimbing.laporan.index', compact('periodes', 'dosen'));
    }

    public function exportPdf(Request $request)
    {
        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();

        $query = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang', 'dosen'])
            ->where('id_dosen', $dosen->id);

        // Apply filters
        if ($request->status) {
            $query->where('status_magang', $request->status);
        }

        if ($request->periode_id) {
            $query->where('periode_id', $request->periode_id);
        }

        $magangs = $query->orderBy('created_at', 'desc')->get();

        // Get filter labels
        $filterLabels = [
            'status' => $request->status ?? 'Semua',
            'periode' => $request->periode_id ? PeriodeMagang::find($request->periode_id)->nama_periode : 'Semua',
            'dosen' => $dosen->nama_lengkap,
        ];

        $pdf = Pdf::loadView('pembimbing.laporan.pdf', compact('magangs', 'filterLabels'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-bimbingan-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();

        // Filter hanya peserta bimbingan dosen ini
        $query = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang', 'dosen'])
            ->where('id_dosen', $dosen->id);

        if ($request->status) {
            $query->where('status_magang', $request->status);
        }

        if ($request->periode_id) {
            $query->where('periode_id', $request->periode_id);
        }

        $magangs = $query->orderBy('created_at', 'desc')->get();

        // Create custom export for pembimbing
        return Excel::download(
            new class($magangs) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithMapping, \Maatwebsite\Excel\Concerns\WithStyles, \Maatwebsite\Excel\Concerns\WithColumnWidths {
                protected $magangs;

                public function __construct($magangs)
                {
                    $this->magangs = $magangs;
                }

                public function collection()
                {
                    return $this->magangs;
                }

                public function headings(): array
                {
                    return [
                        'No',
                        'NIM',
                        'Nama Mahasiswa',
                        'Unit Bisnis',
                        'Periode',
                        'Pembimbing Lapangan',
                        'Tanggal Mulai',
                        'Tanggal Selesai',
                        'Status',
                        'Target Logbook/Minggu',
                    ];
                }

                public function map($magang): array
                {
                    static $no = 0;
                    $no++;

                    return [
                        $no,
                        $magang->mahasiswa->nim ?? '-',
                        $magang->mahasiswa->nama_lengkap ?? '-',
                        $magang->unitBisnis->nama_unit_bisnis ?? '-',
                        $magang->periodeMagang->nama_periode ?? '-',
                        $magang->pembimbing_lapangan ?? '-',
                        optional($magang->periodeMagang?->tanggal_mulai)->format('d/m/Y') ?? '-',
                        optional($magang->periodeMagang?->tanggal_selesai)->format('d/m/Y') ?? '-',
                        $magang->status_magang,
                        $magang->target_book_mingguan,
                    ];
                }

                public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
                {
                    return [
                        1 => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2E8F0']]],
                    ];
                }

                public function columnWidths(): array
                {
                    return [
                        'A' => 5,
                        'B' => 15,
                        'C' => 25,
                        'D' => 20,
                        'E' => 20,
                        'F' => 25,
                        'G' => 15,
                        'H' => 15,
                        'I' => 12,
                        'J' => 20,
                    ];
                }
            },
            'laporan-bimbingan-' . date('Y-m-d') . '.xlsx'
        );
    }
}
