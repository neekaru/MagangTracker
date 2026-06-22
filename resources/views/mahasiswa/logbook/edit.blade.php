@extends('layouts.app')

@section('title', 'Edit Jurnal Kegiatan')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Jurnal Kegiatan Harian</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('mahasiswa.logbook.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('mahasiswa.logbook.update', $logbook) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="tanggal_logbook" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal_logbook" name="tanggal_logbook"
                                value="{{ $logbook->tanggal_logbook->format('Y-m-d') }}" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai"
                                    value="{{ $logbook->jam_mulai ? \Carbon\Carbon::parse($logbook->jam_mulai)->format('H:i') : '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai"
                                    value="{{ $logbook->jam_selesai ? \Carbon\Carbon::parse($logbook->jam_selesai)->format('H:i') : '' }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                            <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4" required>{{ $logbook->deskripsi_kegiatan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="hasil_kegiatan" class="form-label">Output / Hasil</label>
                            <input type="text" class="form-control" id="hasil_kegiatan" name="hasil_kegiatan"
                                value="{{ $logbook->hasil_kegiatan }}">
                        </div>
                        <div class="mb-3">
                            <label for="foto_kegiatan" class="form-label">Bukti Foto (Opsional)</label>
                            <input type="file" class="form-control @error('foto_kegiatan') is-invalid @enderror"
                                id="foto_kegiatan" name="foto_kegiatan"
                                accept="image/jpg,image/jpeg,image/png,image/webp">
                            @error('foto_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG/JPEG/PNG/WEBP, maksimal 5 MB.</small>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('foto_kegiatan');
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const file = fotoInput.files[0];
        if (file && file.size > 5 * 1024 * 1024) {
            e.preventDefault();
            const sizeMB = (file.size / (1024 * 1024)).toFixed(1);
            alert('⚠️ File foto kegiatan terlalu besar (' + sizeMB + ' MB).\n\n' +
                  'Batas maksimal upload adalah 5 MB.\n' +
                  'Silakan kompres / perkecil ukuran file terlebih dahulu.');
            fotoInput.focus();
        }
    });
});
</script>
@endpush
