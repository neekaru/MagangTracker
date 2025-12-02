@extends('layouts.app')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Pengumuman</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/announcements/create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Buat Pengumuman
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Target</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jadwal Libur Idul Fitri</td>
                        <td>Semua</td>
                        <td>01 Des 2025</td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <a href="{{ url('/admin/announcements/1/edit') }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Batas Akhir Pengumpulan Laporan</td>
                        <td>Mahasiswa</td>
                        <td>28 Nov 2025</td>
                        <td><span class="badge bg-secondary">Nonaktif</span></td>
                        <td>
                            <a href="{{ url('/admin/announcements/2/edit') }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
