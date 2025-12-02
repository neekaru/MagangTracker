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
                        <input type="text" class="form-control" id="judul" name="judul" value="Jadwal Libur Idul Fitri" required>
                    </div>
                    <div class="mb-3">
                        <label for="target" class="form-label">Target Audience</label>
                        <select class="form-select" id="target" name="target">
                            <option value="semua" selected>Semua Pengguna</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="pembimbing">Pembimbing</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" id="isi" name="isi" rows="5" required>Diberitahukan kepada seluruh peserta magang dan pembimbing bahwa kegiatan magang diliburkan mulai tanggal 25 Desember 2025 sampai 1 Januari 2026.</textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
                        <label class="form-check-label" for="aktif">Publikasikan Segera</label>
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
