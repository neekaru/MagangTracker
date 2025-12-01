@extends('layouts.app')

@section('title', 'Mahasiswa Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2>Halo, Mahasiswa!</h2>
        <p>Selamat datang di dashboard magang anda.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body text-center">
                <h5 class="card-title">Status Magang</h5>
                <p class="display-6 text-success"><i class="fas fa-check-circle"></i> Aktif</p>
                <p class="text-muted">Unit: IT Support</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body text-center">
                <h5 class="card-title">Kehadiran</h5>
                <p class="display-6 text-primary">95%</p>
                <p class="text-muted">Total 19/20 Hari</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body text-center">
                <h5 class="card-title">Logbook Minggu Ini</h5>
                <p class="display-6 text-warning">4/5</p>
                <a href="{{ url('/mahasiswa/logbook/create') }}" class="btn btn-sm btn-primary">Isi Logbook</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Logbook Terakhir
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Senin, 1 Des 2025</h6>
                        <small class="text-muted">08:00 - 16:00</small>
                    </div>
                    <p class="mb-1">Memperbaiki jaringan LAN di lantai 2.</p>
                    <small class="text-success">Disetujui</small>
                </li>
                <li class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Jumat, 28 Nov 2025</h6>
                        <small class="text-muted">08:00 - 16:00</small>
                    </div>
                    <p class="mb-1">Instalasi OS Windows pada PC baru.</p>
                    <small class="text-success">Disetujui</small>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Pengumuman
            </div>
            <div class="card-body">
                <p>Jangan lupa untuk mengumpulkan laporan bulanan paling lambat tanggal 5 bulan depan.</p>
                <hr>
                <p class="mb-0">Jadwal monitoring dosen pembimbing akan dilaksanakan minggu depan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
