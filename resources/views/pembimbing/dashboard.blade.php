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
            <div class="card-header">Peserta Bimbingan</div>
            <div class="card-body">
                <h5 class="card-title">{{ $peserta_count }}</h5>
                <p class="card-text">Mahasiswa aktif dibimbing.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Logbook Pending</div>
            <div class="card-body">
                <h5 class="card-title">{{ $logbook_pending }}</h5>
                <p class="card-text">Menunggu verifikasi anda.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Absensi Hari Ini</div>
            <div class="card-body">
                <h5 class="card-title">{{ $absensi_hadir }}/{{ $absensi_total }}</h5>
                <p class="card-text">Semua peserta hadir.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                Daftar Peserta Bimbingan (Ringkasan)
            </div>
            <div class="card-body">
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
                        <tr>
                            <td>Ahmad Fulan</td>
                            <td>C030320001</td>
                            <td>IT Support</td>
                            <td><span class="badge bg-success">Lengkap</span></td>
                            <td><a href="{{ url('/pembimbing/peserta/2') }}" class="btn btn-sm btn-primary">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Rina Wati</td>
                            <td>C030320002</td>
                            <td>Keuangan</td>
                            <td><span class="badge bg-warning">Kurang 1</span></td>
                            <td><a href="{{ url('/pembimbing/peserta/1') }}" class="btn btn-sm btn-primary">Detail</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Pengumuman
            </div>
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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Daftar Peserta Bimbingan (Ringkasan)
            </div>
            <div class="card-body">
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
                        <tr>
                            <td>Ahmad Fulan</td>
                            <td>C030320001</td>
                            <td>IT Support</td>
                            <td><span class="badge bg-success">Lengkap</span></td>
                            <td><a href="{{ url('/pembimbing/peserta/2') }}" class="btn btn-sm btn-primary">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Rina Wati</td>
                            <td>C030320002</td>
                            <td>Keuangan</td>
                            <td><span class="badge bg-warning">Kurang 1</span></td>
                            <td><a href="{{ url('/pembimbing/peserta/1') }}" class="btn btn-sm btn-primary">Detail</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
