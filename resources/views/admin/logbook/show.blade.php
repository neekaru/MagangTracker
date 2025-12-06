@extends('layouts.app')

@section('title', 'Detail Logbook')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Logbook</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('logbook.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Logbook Harian</h5>
                @if($logbook->status == 'pending')
                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                @elseif($logbook->status == 'approved')
                    <span class="badge bg-success">Disetujui</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nama Peserta</div>
                    <div class="col-md-8">{{ $logbook->magang->mahasiswa->nama_lengkap ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Unit Penempatan</div>
                    <div class="col-md-8">{{ $logbook->magang->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal</div>
                    <div class="col-md-8">{{ $logbook->tanggal_logbook->format('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Waktu</div>
                    <div class="col-md-8">
                        @if($logbook->jam_mulai && $logbook->jam_selesai)
                            {{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kegiatan</div>
                    <div class="col-md-8">
                        <p>{{ $logbook->deskripsi_kegiatan }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Output / Hasil</div>
                    <div class="col-md-8">{{ $logbook->hasil_kegiatan ?? '-' }}</div>
                </div>
                @if($logbook->foto_kegiatan)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Bukti Foto</div>
                    <div class="col-md-8">
                        <img src="{{ asset('storage/' . $logbook->foto_kegiatan) }}" class="img-fluid rounded border" alt="Bukti Kegiatan">
                    </div>
                </div>
                @endif

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
