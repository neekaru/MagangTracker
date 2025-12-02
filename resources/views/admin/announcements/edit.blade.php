@extends('layouts.app')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Pengumuman</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/announcements') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ url('/admin/announcements/1') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Pengumuman</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="Pengumuman Libur Semester" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" id="isi" name="isi" rows="6" required>Pengumuman penting: Semester ini akan ada libur panjang mulai tanggal 20 Desember 2025 hingga 5 Januari 2026. Selama libur, sistem magang akan tetap aktif untuk pencatatan logbook dan absensi.</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="scope" class="form-label">Scope Pengumuman</label>
                        <select class="form-select" id="scope" name="scope">
                            <option value="global" selected>Global (Semua Pengguna)</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="pembimbing">Pembimbing</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
                        <label class="form-check-label" for="aktif">Aktifkan Pengumuman</label>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection