@extends('layouts.app')

@section('title', 'Detail Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Magang: {{ $magang->mahasiswa->nama_lengkap ?? 'N/A' }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('magang.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('magang.edit', $magang->id) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i> Edit Data
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($magang->mahasiswa->nama_lengkap ?? 'N/A') }}&background=random" class="rounded-circle mb-3" width="100">
                <h5>{{ $magang->mahasiswa->nama_lengkap ?? 'N/A' }}</h5>
                <p class="text-muted mb-1">{{ $magang->mahasiswa->nim ?? 'N/A' }}</p>
                <span class="badge bg-{{ $magang->status_magang == 'Aktif' ? 'success' : 'secondary' }}">{{ $magang->status_magang }}</span>
            </div>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-header">
                Statistik
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Logbook Terisi
                    @php
                        $logbookCount = $magang->logbook->count();
                    @endphp
                    <span class="badge bg-primary rounded-pill">{{ $logbookCount }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Kehadiran
                    @php
                        $totalAbsen = $magang->absen->count();
                        $hadir = $magang->absen->where('status_absensi', 'Hadir')->count();
                        $kehadiranPersen = $totalAbsen > 0 ? round(($hadir / $totalAbsen) * 100) : 0;
                    @endphp
                    <span class="badge bg-success rounded-pill">{{ $kehadiranPersen }}%</span>
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
                        <td>{{ $magang->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>{{ $magang->periodeMagang->nama_periode ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Dosen Pembimbing</th>
                        <td>{{ $magang->dosen->nama_lengkap ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Pembimbing Lapangan</th>
                        <td>{{ $magang->pembimbing_lapangan ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $magang->tanggal_mulai->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $magang->tanggal_selesai->format('d M Y') }}</td>
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
                    @php
                        $recentLogbook = $magang->logbook->sortByDesc('tanggal_logbook')->first();
                        $recentAbsen = $magang->absen->sortByDesc('tanggal')->first();
                    @endphp
                    @if($recentLogbook)
                    <li class="list-group-item">
                        <small class="text-muted">{{ $recentLogbook->tanggal_logbook->format('d M Y') }}</small><br>
                        Mengisi Logbook: {{ Str::limit($recentLogbook->deskripsi_kegiatan, 50) }}
                    </li>
                    @endif
                    @if($recentAbsen)
                    <li class="list-group-item">
                        <small class="text-muted">{{ $recentAbsen->tanggal->format('d M Y') }}</small><br>
                        Absensi: {{ $recentAbsen->status_absensi }} @if($recentAbsen->jam_masuk) - {{ $recentAbsen->jam_masuk->format('H:i') }}@endif
                    </li>
                    @endif
                    @if(!$recentLogbook && !$recentAbsen)
                    <li class="list-group-item text-center text-muted">
                        Belum ada aktivitas
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
