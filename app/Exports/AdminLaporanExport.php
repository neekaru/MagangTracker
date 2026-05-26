<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AdminLaporanExport implements WithMultipleSheets
{
    protected $dataMahasiswa;
    protected $absensis;
    protected $logbooks;

    public function __construct($dataMahasiswa, $absensis, $logbooks)
    {
        $this->dataMahasiswa = $dataMahasiswa;
        $this->absensis = $absensis;
        $this->logbooks = $logbooks;
    }

    public function sheets(): array
    {
        return [
            new AdminRekapMahasiswaSheet($this->dataMahasiswa),
            new AdminRekapAbsensiSheet($this->absensis),
            new AdminRekapLogbookSheet($this->logbooks),
        ];
    }
}
