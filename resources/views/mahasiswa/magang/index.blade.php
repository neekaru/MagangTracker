@extends('layouts.app')

@section('title', 'Informasi Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Informasi Magang</h1>
    @if(!$has_magang)
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ url('/register-magang') }}" class="btn btn-sm btn-primary">Daftar Magang</a>
        </div>
    @endif
</div>

@if($has_magang)
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Status Magang: <span class="fw-bold">{{ $status_magang }}</span>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Unit Penempatan</th>
                        <td>{{ $unit_penempatan }}</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>{{ $periode }}</td>
                    </tr>
                    <tr>
                        <th>Dosen Pembimbing</th>
                        <td>{{ $dosen }}</td>
                    </tr>
                    <tr>
                        <th>Pembimbing Lapangan</th>
                        <td>{{ $pembimbing_lapangan }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $tgl_mulai }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $tgl_selesai }}</td>
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
                    {!! nl2br(e($deskripsi_tugas)) !!}
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
                <h1 class="display-4 fw-bold text-success">{{ $kehadiran_persen }}%</h1>
                <p class="text-muted">Tingkat Kehadiran</p>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $kehadiran_persen }}%" aria-valuenow="{{ $kehadiran_persen }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small>Total Hadir: {{ $hadir }} hari</small>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <h4><i class="fas fa-info-circle"></i> Anda belum terdaftar magang.</h4>
    <p>Silakan daftar magang terlebih dahulu untuk melihat informasi magang Anda.</p>
    <a href="{{ url('/register-magang') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Daftar Magang
    </a>
</div>
@endif
@endsection
