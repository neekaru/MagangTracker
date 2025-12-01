@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Generate Laporan</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Filter Laporan</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Periode Magang</label>
                        <select class="form-select">
                            <option>Semua Periode</option>
                            <option>Ganjil 2025/2026</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Unit Kerja</label>
                        <select class="form-select">
                            <option>Semua Unit</option>
                            <option>IT Support</option>
                            <option>Keuangan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Laporan</label>
                        <select class="form-select">
                            <option>Rekap Nilai Akhir</option>
                            <option>Rekap Absensi</option>
                            <option>Jurnal Kegiatan</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-danger"><i class="fas fa-file-pdf"></i> Download PDF</button>
                        <button class="btn btn-success"><i class="fas fa-file-excel"></i> Download Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
