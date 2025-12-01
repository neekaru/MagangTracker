@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2>Admin Dashboard</h2>
        <p>Welcome back, Admin.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Peserta Aktif</div>
            <div class="card-body">
                <h5 class="card-title">120</h5>
                <p class="card-text">Mahasiswa sedang magang.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Pembimbing</div>
            <div class="card-body">
                <h5 class="card-title">15</h5>
                <p class="card-text">Dosen & Pembimbing Lapangan.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Pendaftaran Baru</div>
            <div class="card-body">
                <h5 class="card-title">5</h5>
                <p class="card-text">Menunggu verifikasi.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Logbook Hari Ini</div>
            <div class="card-body">
                <h5 class="card-title">45</h5>
                <p class="card-text">Logbook terisi hari ini.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Statistik Pendaftaran
            </div>
            <div class="card-body">
                <div class="alert alert-info">Grafik jumlah magang per periode akan muncul di sini.</div>
                <!-- Placeholder for Chart -->
                <div style="height: 200px; background: #eee; display: flex; align-items: center; justify-content: center;">
                    Chart Placeholder
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Aktivitas Terbaru
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Budi mengisi logbook <span class="badge bg-secondary float-end">10m ago</span></li>
                <li class="list-group-item">Siti mendaftar magang <span class="badge bg-secondary float-end">1h ago</span></li>
                <li class="list-group-item">Pak Dosen menilai Andi <span class="badge bg-secondary float-end">2h ago</span></li>
            </ul>
        </div>
    </div>
</div>
@endsection
