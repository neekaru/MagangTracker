@extends('layouts.app')

@section('title', 'Tambah Periode Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Periode Magang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/periode-magang') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ url('/admin/periode-magang') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Periode</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Semester Ganjil 2025/2026" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif" selected>Nonaktif</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Periode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
