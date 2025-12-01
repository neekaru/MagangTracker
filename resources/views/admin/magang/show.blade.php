@extends('layouts.app')

@section('title', 'Detail Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Magang: Siti Aminah</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/magang') }}" class="btn btn-sm btn-secondary me-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ url('/admin/magang/1/edit') }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i> Edit Data
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=random" class="rounded-circle mb-3" width="100">
                <h5>Siti Aminah</h5>
                <p class="text-muted mb-1">C030320005</p>
                <span class="badge bg-success">Aktif</span>
            </div>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-header">
                Statistik
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Logbook Terisi
                    <span class="badge bg-primary rounded-pill">45</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Kehadiran
                    <span class="badge bg-success rounded-pill">95%</span>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                Data Magang
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Unit Penempatan</th>
                        <td>IT Support</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>Jan 2025 - Jun 2025</td>
                    </tr>
                    <tr>
                        <th>Dosen Pembimbing</th>
                        <td>Pak Budi</td>
                    </tr>
                    <tr>
                        <th>Pembimbing Lapangan</th>
                        <td>Pak Joko (IT Manager)</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>01 Jan 2025</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>30 Jun 2025</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                Aktivitas Terakhir
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <small class="text-muted">01 Des 2025</small><br>
                        Mengisi Logbook: Maintenance Server
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted">30 Nov 2025</small><br>
                        Absensi Masuk: 07:55
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
