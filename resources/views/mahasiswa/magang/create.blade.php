@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Magang</h1>
    <form action="{{ route('magang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="periode_id" class="form-label">Periode Magang</label>
            <select class="form-control" id="periode_id" name="periode_id" required>
                <option value="">Pilih Periode</option>
                @foreach($periodes as $periode)
                    <option value="{{ $periode->id }}">{{ $periode->nama_periode }} ({{ $periode->tanggal_mulai->format('d M Y') }} - {{ $periode->tanggal_selesai->format('d M Y') }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="unit_id" class="form-label">Unit Bisnis</label>
            <select class="form-control" id="unit_id" name="unit_id" required>
                <option value="">Pilih Unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->nama_unit_bisnis }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="unit_lainnya" class="form-label">Unit Lainnya (Opsional)</label>
            <input type="text" class="form-control" id="unit_lainnya" name="unit_lainnya" placeholder="Jika unit tidak tersedia">
        </div>
        <div class="mb-3">
            <label for="id_dosen" class="form-label">Dosen Pembimbing</label>
            <select class="form-control" id="id_dosen" name="id_dosen" required>
                <option value="">Pilih Dosen</option>
                @foreach($dosens as $dosen)
                    <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="pembimbing_lapangan" class="form-label">Pembimbing Lapangan</label>
            <input type="text" class="form-control" id="pembimbing_lapangan" name="pembimbing_lapangan" required>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="tugas_description" class="form-label">Deskripsi Tugas</label>
            <textarea class="form-control" id="tugas_description" name="tugas_description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="target_book_mingguan" class="form-label">Target Logbook Mingguan</label>
            <input type="number" class="form-control" id="target_book_mingguan" name="target_book_mingguan" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar Magang</button>
        <a href="{{ route('mahasiswa.magang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection