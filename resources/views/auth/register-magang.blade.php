<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Magang - MagangTracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            filter: blur(4px);
            z-index: -1;
        }
        .card {
            background: rgba(255, 255, 255, 0.95);
        }
    </style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Formulir Pendaftaran Magang</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('register.magang.store') }}" method="POST">
                        @csrf
                        <h5 class="mb-3">Data Pribadi</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ $mahasiswa->nama_lengkap }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" value="{{ $mahasiswa->nim }}" readonly>
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4">Rencana Magang</h5>
                        <div class="mb-3">
                            <label for="id_unit_bisnis" class="form-label">Unit Tujuan</label>
                            <select class="form-select @error('id_unit_bisnis') is-invalid @enderror" id="id_unit_bisnis" name="id_unit_bisnis" required>
                                <option value="">Pilih Unit...</option>
                                @foreach($unitBisnis as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->nama_unit_bisnis }}</option>
                                @endforeach
                            </select>
                            @error('id_unit_bisnis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_periode_magang" class="form-label">Periode Magang</label>
                            <select class="form-select @error('id_periode_magang') is-invalid @enderror" id="id_periode_magang" name="id_periode_magang" required>
                                <option value="">Pilih Periode...</option>
                                @foreach($periodeMagang as $periode)
                                    <option value="{{ $periode->id }}">{{ $periode->nama_periode }}</option>
                                @endforeach
                            </select>
                            @error('id_periode_magang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_dosen" class="form-label">Dosen Pembimbing</label>

                            <select class="form-select @error('id_dosen') is-invalid @enderror" id="id_dosen" name="id_dosen" required>
                                <option value="">Pilih Dosen Pembimbing...</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('id_dosen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pembimbing_lapangan" class="form-label">Pembimbing Lapangan</label>
                            <input type="text" class="form-control @error('pembimbing_lapangan') is-invalid @enderror" id="pembimbing_lapangan" name="pembimbing_lapangan" value="{{ old('pembimbing_lapangan') }}" placeholder="Nama dan jabatan pembimbing di tempat magang" required>
                            @error('pembimbing_lapangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Pendaftaran</button>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
