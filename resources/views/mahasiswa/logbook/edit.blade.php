@extends('layouts.app')

@section('title', 'Edit Logbook')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Logbook Harian</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/mahasiswa/logbook') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ url('/mahasiswa/logbook/1') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="2025-12-01" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="08:00" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="16:00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="kegiatan" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control" id="kegiatan" name="kegiatan" rows="4" required>Memperbaiki jaringan LAN di lantai 2.</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="output" class="form-label">Output / Hasil</label>
                        <input type="text" class="form-control" id="output" name="output" value="Koneksi stabil">
                    </div>
                    <div class="mb-3">
                        <label for="bukti" class="form-label">Bukti Foto (Opsional)</label>
                        <input type="file" class="form-control" id="bukti" name="bukti">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
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
