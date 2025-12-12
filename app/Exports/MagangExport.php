<?php

namespace App\Exports;

use App\Models\Magang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MagangExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $status;
    protected $periode_id;
    protected $unit_id;

    public function __construct($status = null, $periode_id = null, $unit_id = null)
    {
        $this->status = $status;
        $this->periode_id = $periode_id;
        $this->unit_id = $unit_id;
    }

    public function collection()
    {
        $query = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang', 'dosen']);

        if ($this->status) {
            $query->where('status_magang', $this->status);
        }

        if ($this->periode_id) {
            $query->where('periode_id', $this->periode_id);
        }

        if ($this->unit_id) {
            $query->where('unit_id', $this->unit_id);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama Mahasiswa',
            'Unit Bisnis',
            'Periode',
            'Dosen Pembimbing',
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
            $magang->dosen->nama_lengkap ?? '-',
            $magang->pembimbing_lapangan ?? '-',
            $magang->tanggal_mulai ? $magang->tanggal_mulai->format('d/m/Y') : '-',
            $magang->tanggal_selesai ? $magang->tanggal_selesai->format('d/m/Y') : '-',
            $magang->status_magang,
            $magang->target_book_mingguan,
        ];
    }

    public function styles(Worksheet $sheet)
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
            'G' => 25,
            'H' => 15,
            'I' => 15,
            'J' => 12,
            'K' => 20,
        ];
    }
}
