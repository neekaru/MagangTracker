@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Absensi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-sm btn-secondary">
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
                    <div class="col-md-8">{{ $absen->magang->mahasiswa->nama_lengkap ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">NIM</div>
                    <div class="col-md-8">{{ $absen->magang->mahasiswa->nim ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal</div>
                    <div class="col-md-8">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Jenis Absensi</div>
                    <div class="col-md-8">
                        @if($absen->jenis_absen == 'masuk')
                            <span class="badge bg-primary">Masuk</span>
                        @else
                            <span class="badge bg-secondary">Pulang</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Jam</div>
                    <div class="col-md-8">{{ $absen->jam ? \Carbon\Carbon::parse($absen->jam, 'H:i:s')->format('H:i') . ' WIB' : '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status</div>
                    <div class="col-md-8">
                        @if($absen->status_kehadiran == 'Hadir')
                            <span class="badge bg-success">Hadir</span>
                        @elseif($absen->status_kehadiran == 'Izin')
                            <span class="badge bg-warning text-dark">Izin</span>
                        @else
                            <span class="badge bg-danger">Sakit</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Lokasi</div>
                    <div class="col-md-8">{{ $absen->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Keterangan</div>
                    <div class="col-md-8">{{ $absen->keterangan ?: '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Waktu Input</div>
                    <div class="col-md-8">{{ $absen->created_at ? \Carbon\Carbon::parse($absen->created_at)->format('d F Y, H:i') . ' WIB' : '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
