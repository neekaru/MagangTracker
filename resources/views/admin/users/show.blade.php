@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail User: Budi Santoso</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/users') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" class="rounded-circle mb-3" width="100">
                <h5>Budi Santoso</h5>
                <p class="text-muted mb-1">budi@dosen.com</p>
                <span class="badge bg-info text-dark">Pembimbing</span>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                Informasi Tambahan
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">NIP / NIK</th>
                        <td>19850101 201001 1 001</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>Dosen Teknik Informatika</td>
                    </tr>
                    <tr>
                        <th>Status Akun</th>
                        <td><span class="badge bg-success">Aktif</span></td>
                    </tr>
                    <tr>
                        <th>Terdaftar Sejak</th>
                        <td>01 Jan 2024</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
