<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PembimbingAbsensiSheet implements WithTitle, FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $absensis;
    protected $no = 0;

    public function __construct($absensis)
    {
        $this->absensis = $absensis;
    }

    public function title(): string
    {
        return 'Absensi';
    }

    public function collection()
    {
        return $this->absensis;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jenis Absensi',
            'Jam',
            'Status Kehadiran',
            'Status Validasi',
            'Keterangan',
        ];
    }

    public function map($absensi): array
    {
        $this->no++;

        return [
            $this->no,
            \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y'),
            $absensi->jenis_absen ? ucfirst($absensi->jenis_absen) : '-',
            $absensi->jam ? \Carbon\Carbon::parse($absensi->jam)->format('H:i') : '-',
            $absensi->status_kehadiran,
            ucfirst($absensi->status_validasi),
            $absensi->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']]
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 12,
            'C' => 15,
            'D' => 10,
            'E' => 15,
            'F' => 15,
            'G' => 30,
        ];
    }
}
