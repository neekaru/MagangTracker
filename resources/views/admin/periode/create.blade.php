@extends('layouts.app')

@section('title', 'Tambah Periode Magang')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Periode Magang</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('periode-magang.index') }}" class="btn btn-sm btn-secondary">
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
                    <form action="{{ route('periode-magang.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_periode" class="form-label">Nama Periode <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_periode') is-invalid @enderror"
                                id="nama_periode" name="nama_periode" value="{{ old('nama_periode') }}"
                                placeholder="Contoh: Semester Ganjil 2025/2026" required>
                            @error('nama_periode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                    id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                    id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                    required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status_magang" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status_magang') is-invalid @enderror" id="status_magang"
                                name="status_magang" required>
                                <option value="Aktif" {{ old('status_magang') == 'Aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="Nonaktif"
                                    {{ old('status_magang', 'Nonaktif') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                            @error('status_magang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('periode-magang.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Periode</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
