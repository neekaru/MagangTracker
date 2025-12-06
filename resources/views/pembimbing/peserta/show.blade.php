@extends('layouts.app')

@section('title', 'Detail Peserta')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Peserta: {{ $peserta->mahasiswa->nama_lengkap ?? 'N/A' }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('pembimbing.peserta.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($peserta->mahasiswa->nama_lengkap ?? 'N/A') }}&background=random" class="rounded-circle mb-3" width="100">
                <h5>{{ $peserta->mahasiswa->nama_lengkap ?? 'N/A' }}</h5>
                <p class="text-muted mb-1">{{ $peserta->mahasiswa->nisn ?? 'N/A' }}</p>
                <p class="badge bg-primary">{{ $peserta->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">Statistik Magang</h5>
                <div class="row text-center mt-4">
                    <div class="col-4">
                        @php
                            $totalAbsen = $peserta->absen->count();
                            $hadir = $peserta->absen->where('status_absensi', 'Hadir')->count();
                            $kehadiranPersen = $totalAbsen > 0 ? round(($hadir / $totalAbsen) * 100) : 0;
                        @endphp
                        <h3>{{ $kehadiranPersen }}%</h3>
                        <p class="text-muted">Kehadiran</p>
                    </div>
                    <div class="col-4">
                        @php
                            $logbookDisetujui = $peserta->logbook->where('status', 'approved')->count();
                        @endphp
                        <h3>{{ $logbookDisetujui }}</h3>
                        <p class="text-muted">Logbook Disetujui</p>
                    </div>
                    <div class="col-4">
                        @php
                            $logbookPending = $peserta->logbook->where('status', 'pending')->count();
                        @endphp
                        <h3>{{ $logbookPending }}</h3>
                        <p class="text-muted">Logbook Pending</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="detailTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="logbook-tab" data-bs-toggle="tab" data-bs-target="#logbook" type="button">Logbook</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi" type="button">Absensi</button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="detailTabContent">
            <!-- Logbook Tab -->
            <div class="tab-pane fade show active" id="logbook" role="tabpanel">
                <table class="table table-striped w-100" id="logbookTable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01 Des 2025</td>
                            <td>Maintenance Server</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>30 Nov 2025</td>
                            <td>Instalasi Jaringan</td>
                            <td><span class="badge bg-success">Disetujui</span></td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Absensi Tab -->
            <div class="tab-pane fade" id="absensi" role="tabpanel">
                <table class="table table-striped w-100" id="absensiTable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01 Des 2025</td>
                            <td>07:55</td>
                            <td>Hadir</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>30 Nov 2025</td>
                            <td>08:00</td>
                            <td>Hadir</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#logbookTable').DataTable();
        $('#absensiTable').DataTable();
    });
</script>
@endpush
