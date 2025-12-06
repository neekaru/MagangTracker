@extends('layouts.app')

@section('title', 'Edit Logbook')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Logbook Harian</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('mahasiswa.logbook.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('mahasiswa.logbook.update', $logbook) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tanggal_logbook" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_logbook" name="tanggal_logbook" value="{{ $logbook->tanggal_logbook->format('Y-m-d') }}" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="{{ $logbook->jam_mulai }}">
                        </div>
                        <div class="col-md-6">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="{{ $logbook->jam_selesai }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4" required>{{ $logbook->deskripsi_kegiatan }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="hasil_kegiatan" class="form-label">Output / Hasil</label>
                        <input type="text" class="form-control" id="hasil_kegiatan" name="hasil_kegiatan" value="{{ $logbook->hasil_kegiatan }}">
                    </div>
                    <div class="mb-3">
                        <label for="foto_kegiatan" class="form-label">Bukti Foto (Opsional)</label>
                        <input type="file" class="form-control" id="foto_kegiatan" name="foto_kegiatan">
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
