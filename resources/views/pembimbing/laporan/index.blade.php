@extends('layouts.app')

@section('title', 'Laporan Bimbingan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Peserta Bimbingan</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Pilih Peserta</label>
                        <select class="form-select">
                            <option>Semua Peserta</option>
                            <option>Siti Aminah</option>
                            <option>Budi Santoso</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Laporan</label>
                        <select class="form-select">
                            <option>Logbook Kegiatan</option>
                            <option>Rekap Absensi</option>
                            <option>Lembar Penilaian</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-danger"><i class="fas fa-file-pdf"></i> Download PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
