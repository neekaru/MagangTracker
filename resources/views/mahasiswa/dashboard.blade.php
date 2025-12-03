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
            <div class="card-header"><i class="fas fa-check-circle me-2"></i>Status Magang</div>
            <div class="card-body text-center">
                <h5 class="card-title">Status Magang <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" title="Status resmi kepesertaan magang Anda."></i></h5>
                <p class="display-6 {{ $status_magang == 'Aktif' ? 'text-success' : 'text-secondary' }}"><i class="fas fa-check-circle"></i> {{ $status_magang }}</p>
                <p class="text-muted">Unit: {{ $unit_penempatan }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><i class="fas fa-clock me-2"></i>Kehadiran</div>
            <div class="card-body text-center">
                <h5 class="card-title">Kehadiran <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" title="Persentase kehadiran berdasarkan hari kerja yang telah berjalan."></i></h5>
                <p class="display-6 text-primary">{{ $kehadiran_persen }}%</p>
                <p class="text-muted">Total {{ $kehadiran_total }}/{{ $kehadiran_max }} Hari</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><i class="fas fa-book me-2"></i>Logbook Minggu Ini</div>
            <div class="card-body text-center">
                <h5 class="card-title">Logbook Minggu Ini <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" title="Jumlah logbook yang telah diisi pada minggu ini."></i></h5>
                <p class="display-6 text-warning">{{ $logbook_minggu_ini }}/{{ $logbook_target }}</p>
                <a href="{{ url('/mahasiswa/logbook/create') }}" class="btn btn-sm btn-primary">Isi Logbook</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-book me-2"></i>Logbook Terakhir</div>
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
            <div class="card-header"><i class="fas fa-bullhorn me-2"></i>Pengumuman</div>
            <div class="card-body">
                @forelse($announcements as $announcement)
                    <div class="mb-3">
                        <h6 class="fw-bold">{{ $announcement['title'] }} <small class="text-muted float-end">{{ $announcement['date'] }}</small></h6>
                        <p class="mb-0">{{ $announcement['content'] }}</p>
                    </div>
                    @if(!$loop->last) <hr> @endif
                @empty
                    <p class="text-muted">Tidak ada pengumuman terbaru.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
