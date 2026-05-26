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

class PembimbingLogbookSheet implements WithTitle, FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $logbooks;
    protected $no = 0;

    public function __construct($logbooks)
    {
        $this->logbooks = $logbooks;
    }

    public function title(): string
    {
        return 'Logbook';
    }

    public function collection()
    {
        return $this->logbooks;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Deskripsi Kegiatan',
            'Hasil Kegiatan',
            'Status',
        ];
    }

    public function map($logbook): array
    {
        $this->no++;

        return [
            $this->no,
            \Carbon\Carbon::parse($logbook->tanggal_logbook)->format('d/m/Y'),
            $logbook->jam_mulai ? \Carbon\Carbon::parse($logbook->jam_mulai)->format('H:i') : '-',
            $logbook->jam_selesai ? \Carbon\Carbon::parse($logbook->jam_selesai)->format('H:i') : '-',
            $logbook->deskripsi_kegiatan ?? '-',
            $logbook->hasil_kegiatan ?? '-',
            ucfirst($logbook->status),
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
            'B' => 12,
            'C' => 10,
            'D' => 10,
            'E' => 50,
            'F' => 50,
            'G' => 12,
        ];
    }
}
