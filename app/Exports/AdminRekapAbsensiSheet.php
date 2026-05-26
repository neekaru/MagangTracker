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

class AdminRekapAbsensiSheet implements WithTitle, FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $absensis;
    protected $no = 0;

    public function __construct($absensis)
    {
        $this->absensis = $absensis;
    }

    public function title(): string
    {
        return 'Rekap Absensi';
    }

    public function collection()
    {
        return $this->absensis;
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama',
            'Tanggal',
            'Jenis',
            'Jam',
            'Status',
            'Validasi',
        ];
    }

    public function map($absensi): array
    {
        $this->no++;

        return [
            $this->no,
            $absensi->magang->mahasiswa->nim ?? '-',
            $absensi->magang->mahasiswa->nama_lengkap ?? '-',
            \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y'),
            $absensi->jenis_absen ? ucfirst($absensi->jenis_absen) : '-',
            $absensi->jam ? substr($absensi->jam, 0, 5) : '-',
            $absensi->status_kehadiran,
            ucfirst($absensi->status_validasi),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '70AD47']]
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 25,
            'D' => 12,
            'E' => 10,
            'F' => 8,
            'G' => 12,
            'H' => 12,
        ];
    }
}
