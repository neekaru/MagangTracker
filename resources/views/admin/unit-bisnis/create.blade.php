@extends('layouts.app')

@section('title', 'Tambah Unit Bisnis')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Unit Bisnis</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('unit-bisnis.index') }}" class="btn btn-sm btn-secondary">
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
                    <form action="{{ route('unit-bisnis.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_unit_bisnis" class="form-label">Nama Unit Bisnis <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_unit_bisnis') is-invalid @enderror"
                                id="nama_unit_bisnis" name="nama_unit_bisnis" value="{{ old('nama_unit_bisnis') }}"
                                placeholder="Contoh: IT Development, Marketing, Finance" required>
                            @error('nama_unit_bisnis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nama unit bisnis harus unik</small>
                        </div>

                        <div class="mb-3">
                            <label for="id_periode" class="form-label">Periode Magang</label>
                            <select class="form-control @error('id_periode') is-invalid @enderror" id="id_periode" name="id_periode">
                                <option value="">Pilih Periode (Opsional)</option>
                                @foreach($periodes as $periode)
                                    <option value="{{ $periode->id }}" {{ old('id_periode') == $periode->id ? 'selected' : '' }}>
                                        {{ $periode->nama_periode }} ({{ $periode->tanggal_mulai->format('M Y') }} - {{ $periode->tanggal_selesai->format('M Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_periode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('unit-bisnis.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Unit Bisnis</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
