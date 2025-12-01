@extends('layouts.app')

@section('title', 'Detail Logbook')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Logbook</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/logbook') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Logbook Harian</h5>
                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nama Peserta</div>
                    <div class="col-md-8">Siti Aminah</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal</div>
                    <div class="col-md-8">01 Desember 2025</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Waktu</div>
                    <div class="col-md-8">08:00 - 16:00</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kegiatan</div>
                    <div class="col-md-8">
                        <p>Melakukan maintenance server rutin, pengecekan log error, dan update patch keamanan terbaru pada server database.</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Output / Hasil</div>
                    <div class="col-md-8">Laporan maintenance server bulan Desember.</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Bukti Foto</div>
                    <div class="col-md-8">
                        <img src="https://via.placeholder.com/400x300?text=Bukti+Kegiatan" class="img-fluid rounded border" alt="Bukti Kegiatan">
                    </div>
                </div>

                <hr>
                
                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-success"><i class="fas fa-check"></i> Setujui</button>
                    <button class="btn btn-danger"><i class="fas fa-times"></i> Tolak</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
