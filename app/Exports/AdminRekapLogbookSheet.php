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

class AdminRekapLogbookSheet implements WithTitle, FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $logbooks;
    protected $no = 0;

    public function __construct($logbooks)
    {
        $this->logbooks = $logbooks;
    }

    public function title(): string
    {
        return 'Rekap Logbook';
    }

    public function collection()
    {
        return $this->logbooks;
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama',
            'Tanggal',
            'Jam',
            'Deskripsi',
            'Status',
        ];
    }

    public function map($logbook): array
    {
        $this->no++;

        return [
            $this->no,
            $logbook->magang->mahasiswa->nim ?? '-',
            $logbook->magang->mahasiswa->nama_lengkap ?? '-',
            \Carbon\Carbon::parse($logbook->tanggal_logbook)->format('d/m/Y'),
            ($logbook->jam_mulai ? substr($logbook->jam_mulai, 0, 5) : '-') . ' - ' . ($logbook->jam_selesai ? substr($logbook->jam_selesai, 0, 5) : '-'),
            $logbook->deskripsi_kegiatan ?? '-',
            ucfirst($logbook->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC000']]
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
            'E' => 15,
            'F' => 50,
            'G' => 12,
        ];
    }
}
