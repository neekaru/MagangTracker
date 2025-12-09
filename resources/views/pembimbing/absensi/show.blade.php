@extends('layouts.app')

@section('title', 'Detail Absensi - Validasi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Absensi - Validasi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('pembimbing.absensi.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Informasi Absensi</h5>
            </div>
            <div class="card-body">
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
                    <div class="col-md-8">{{ $absen->jam ? substr($absen->jam, 0, 5) . ' WIB' : '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status Kehadiran</div>
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
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status Validasi</div>
                    <div class="col-md-8">
                        @if($absen->status_validasi === 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($absen->status_validasi === 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-secondary">Menunggu Validasi</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Validasi -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="fas fa-check-circle"></i> Validasi Absensi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pembimbing.absensi.update', $absen->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status_kehadiran" class="form-label">Konfirmasi Status Kehadiran</label>
                        <select name="status_kehadiran" id="status_kehadiran" class="form-select" required>
                            <option value="Hadir" @selected($absen->status_kehadiran == 'Hadir')>Hadir</option>
                            <option value="Izin" @selected($absen->status_kehadiran == 'Izin')>Izin</option>
                            <option value="Sakit" @selected($absen->status_kehadiran == 'Sakit')>Sakit</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status_validasi" class="form-label">Status Validasi</label>
                        <select name="status_validasi" id="status_validasi" class="form-select" required>
                            <option value="pending" @selected($absen->status_validasi == 'pending')>Menunggu Validasi</option>
                            <option value="approved" @selected($absen->status_validasi == 'approved')>Setujui</option>
                            <option value="rejected" @selected($absen->status_validasi == 'rejected')>Tolak</option>
                        </select>
                        <small class="text-muted">Pilih status untuk menyelesaikan validasi absensi ini</small>
                    </div>

                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                        <a href="{{ route('pembimbing.absensi.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Validasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
