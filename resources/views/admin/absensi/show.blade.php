@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Absensi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/absensi') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Informasi Absensi</h5>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nama Peserta</div>
                    <div class="col-md-8">Siti Aminah</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal</div>
                    <div class="col-md-8">01 Desember 2025</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Jam Masuk</div>
                    <div class="col-md-8">07:55 WIB</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status</div>
                    <div class="col-md-8"><span class="badge bg-success">Hadir</span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Lokasi</div>
                    <div class="col-md-8">Kantor Pusat (Lat: -2.5, Long: 112.9)</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Keterangan</div>
                    <div class="col-md-8">-</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
