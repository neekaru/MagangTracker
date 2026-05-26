<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PembimbingLaporanExport implements WithMultipleSheets
{
    protected $absensis;
    protected $logbooks;

    public function __construct($absensis, $logbooks)
    {
        $this->absensis = $absensis;
        $this->logbooks = $logbooks;
    }

    public function sheets(): array
    {
        return [
            new PembimbingAbsensiSheet($this->absensis),
            new PembimbingLogbookSheet($this->logbooks),
        ];
    }
}
