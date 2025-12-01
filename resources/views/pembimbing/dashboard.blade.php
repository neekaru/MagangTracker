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
                <h5 class="card-title">8</h5>
                <p class="card-text">Mahasiswa aktif dibimbing.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Logbook Pending</div>
            <div class="card-body">
                <h5 class="card-title">12</h5>
                <p class="card-text">Menunggu verifikasi anda.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Absensi Hari Ini</div>
            <div class="card-body">
                <h5 class="card-title">8/8</h5>
                <p class="card-text">Semua peserta hadir.</p>
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
                            <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>
                        </tr>
                        <tr>
                            <td>Rina Wati</td>
                            <td>C030320002</td>
                            <td>Keuangan</td>
                            <td><span class="badge bg-warning">Kurang 1</span></td>
                            <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
