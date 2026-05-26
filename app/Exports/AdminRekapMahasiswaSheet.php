<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminRekapMahasiswaSheet implements WithTitle, FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    protected $dataMahasiswa;

    public function __construct($dataMahasiswa)
    {
        $this->dataMahasiswa = $dataMahasiswa;
    }

    public function title(): string
    {
        return 'Rekap Mahasiswa';
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Prodi',
            'Unit Bisnis',
            'Dosen Pembimbing',
            'Periode',
            'Status',
            'Hadir',
            'Izin',
            'Sakit',
            'Kehadiran %',
            'Total Logbook',
            'Approved',
            'Pending',
            'Rejected',
        ];
    }

    public function array(): array
    {
        return array_map(function($item) {
            return [
                $item['nim'],
                $item['nama'],
                $item['prodi'],
                $item['unit'],
                $item['dosen'],
                $item['periode'],
                $item['status'],
                $item['total_kehadiran'],
                $item['total_izin'],
                $item['total_sakit'],
                $item['persentase_kehadiran'] . '%',
                $item['total_logbook'],
                $item['logbook_approved'],
                $item['logbook_pending'],
                $item['logbook_rejected'],
            ];
        }, $this->dataMahasiswa);
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
            'A' => 15,
            'B' => 25,
            'C' => 20,
            'D' => 20,
            'E' => 25,
            'F' => 20,
            'G' => 12,
            'H' => 8,
            'I' => 8,
            'J' => 8,
            'K' => 12,
            'L' => 12,
            'M' => 10,
            'N' => 10,
            'O' => 10,
        ];
    }
}
