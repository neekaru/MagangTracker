@extends('layouts.app')

@section('title', 'Pembimbing Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h2>Pembimbing Dashboard</h2>
            <p>Selamat datang, Bapak/Ibu Pembimbing.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header"><i class="fas fa-users me-2"></i>Peserta Bimbingan</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $peserta_count }}</h5>
                    <p class="card-text">Mahasiswa aktif dibimbing.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header"><i class="fas fa-book me-2"></i>Logbook Pending</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $logbook_pending }}</h5>
                    <p class="card-text">Menunggu verifikasi anda.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header"><i class="fas fa-clock me-2"></i>Absensi Hari Ini</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $absensi_hadir }}/{{ $absensi_total }}</h5>
                    <p class="card-text">Semua peserta hadir.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-users me-2"></i>Daftar Peserta Bimbingan (Ringkasan)
                </div>
                <div class="card-body">
                    @if($peserta->isEmpty())
                        <p class="text-muted">Belum ada peserta bimbingan.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Unit</th>
                                    <th>Logbook (Minggu Ini)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peserta as $p)
                                    <tr>
                                        <td>{{ $p['nama'] }}</td>
                                        <td>{{ $p['nim'] }}</td>
                                        <td>{{ $p['unit'] }}</td>
                                        <td>
                                            @if($p['logbook_count'] >= $p['target_weekly'])
                                                <span class="badge bg-success">Lengkap ({{ $p['logbook_count'] }}/{{ $p['target_weekly'] }})</span>
                                            @else
                                                <span class="badge bg-warning">Kurang {{ $p['target_weekly'] - $p['logbook_count'] }} ({{ $p['logbook_count'] }}/{{ $p['target_weekly'] }})</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('pembimbing.peserta.show', $p['id']) }}" class="btn btn-sm btn-primary">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
