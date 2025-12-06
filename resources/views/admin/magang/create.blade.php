@extends('layouts.app')

@section('title', 'Tambah Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Magang Mahasiswa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('magang.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('magang.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id_mahasiswa" class="form-label">Mahasiswa <span class="text-danger">*</span></label>
                        <select class="form-control @error('id_mahasiswa') is-invalid @enderror" id="id_mahasiswa" name="id_mahasiswa" required>
                            <option value="">Pilih Mahasiswa</option>
                            @foreach($mahasiswas as $mahasiswa)
                                <option value="{{ $mahasiswa->id }}" {{ old('id_mahasiswa') == $mahasiswa->id ? 'selected' : '' }}>
                                    {{ $mahasiswa->nama_lengkap }} ({{ $mahasiswa->nim }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_mahasiswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Unit Bisnis <span class="text-danger">*</span></label>
                        <select class="form-control @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id" required>
                            <option value="">Pilih Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama_unit_bisnis }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="periode_id" class="form-label">Periode Magang <span class="text-danger">*</span></label>
                        <select class="form-control @error('periode_id') is-invalid @enderror" id="periode_id" name="periode_id" required>
                            <option value="">Pilih Periode</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->id }}" {{ old('periode_id') == $periode->id ? 'selected' : '' }}>
                                    {{ $periode->nama_periode }} ({{ $periode->tanggal_mulai->format('M Y') }} - {{ $periode->tanggal_selesai->format('M Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('periode_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_dosen" class="form-label">Dosen Pembimbing <span class="text-danger">*</span></label>
                        <select class="form-control @error('id_dosen') is-invalid @enderror" id="id_dosen" name="id_dosen" required>
                            <option value="">Pilih Dosen</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}" {{ old('id_dosen') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_dosen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pembimbing_lapangan" class="form-label">Pembimbing Lapangan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('pembimbing_lapangan') is-invalid @enderror" id="pembimbing_lapangan" name="pembimbing_lapangan" value="{{ old('pembimbing_lapangan') }}" required>
                        @error('pembimbing_lapangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tugas_description" class="form-label">Deskripsi Tugas <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('tugas_description') is-invalid @enderror" id="tugas_description" name="tugas_description" rows="4" required>{{ old('tugas_description') }}</textarea>
                        @error('tugas_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="target_book_mingguan" class="form-label">Target Logbook Mingguan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('target_book_mingguan') is-invalid @enderror" id="target_book_mingguan" name="target_book_mingguan" min="1" value="{{ old('target_book_mingguan', 5) }}" required>
                        @error('target_book_mingguan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="unit_lainnya" class="form-label">Unit Lainnya (Opsional)</label>
                        <input type="text" class="form-control @error('unit_lainnya') is-invalid @enderror" id="unit_lainnya" name="unit_lainnya" value="{{ old('unit_lainnya') }}">
                        @error('unit_lainnya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('magang.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Magang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection