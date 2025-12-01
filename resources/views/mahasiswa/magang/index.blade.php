@extends('layouts.app')

@section('title', 'Informasi Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informasi Magang</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Status Magang: <span class="fw-bold">Aktif</span>
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
                        <td>Pak Budi (NIP: 19850101 201001 1 001)</td>
                    </tr>
                    <tr>
                        <th>Pembimbing Lapangan</th>
                        <td>{{ $pembimbing_lapangan ?? 'Pak Joko (IT Manager)' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $tgl_mulai ?? '01 Jan 2025' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $tgl_selesai ?? '30 Jun 2025' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                Deskripsi Tugas
            </div>
            <div class="card-body">
                <p>
                    {!! nl2br(e($deskripsi_tugas ?? 'Sebagai peserta magang di unit IT Support, tugas utama Anda meliputi:
- Membantu maintenance perangkat keras dan lunak kantor.
- Melakukan troubleshooting jaringan dasar.
- Membantu instalasi dan konfigurasi software.
- Mendokumentasikan kegiatan perbaikan dan maintenance.')) !!}
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                Statistik Kehadiran
            </div>
            <div class="card-body text-center">
                <h1 class="display-4 fw-bold text-success">95%</h1>
                <p class="text-muted">Tingkat Kehadiran</p>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small>Total Hadir: 45 hari</small>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                Kontak Penting
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Admin Magang</strong><br>
                        <i class="fas fa-phone me-2"></i> 0812-3456-7890
                    </li>
                    <li class="mb-2">
                        <strong>Dosen Pembimbing</strong><br>
                        <i class="fas fa-envelope me-2"></i> budi@dosen.com
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
