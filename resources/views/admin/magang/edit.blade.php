@extends('layouts.app')

@section('title', 'Edit Data Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data Magang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('magang.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('magang.update', $magang->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h5 class="mb-3">Informasi Peserta</h5>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Nama Peserta</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext" value="{{ $magang->mahasiswa->nama_lengkap ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Detail Penempatan</h5>
                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Unit Penempatan</label>
                        <select class="form-select" id="unit_id" name="unit_id">
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ $magang->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit_bisnis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unit_lainnya" class="form-label">Unit Lainnya</label>
                        <input type="text" class="form-control" id="unit_lainnya" name="unit_lainnya" value="{{ $magang->unit_lainnya }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="periode_id" class="form-label">Periode Magang</label>
                        <select class="form-select" id="periode_id" name="periode_id">
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->id }}" {{ $magang->periode_id == $periode->id ? 'selected' : '' }}>{{ $periode->nama_periode }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_dosen" class="form-label">Dosen Pembimbing</label>
                        <select class="form-select" id="id_dosen" name="id_dosen">
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}" {{ $magang->id_dosen == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pembimbing_lapangan" class="form-label">Pembimbing Lapangan</label>
                        <input type="text" class="form-control" id="pembimbing_lapangan" name="pembimbing_lapangan" value="{{ $magang->pembimbing_lapangan }}" placeholder="Masukkan nama dan jabatan pembimbing lapangan">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $magang->tanggal_mulai->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ $magang->tanggal_selesai->format('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status_magang" class="form-label">Status Magang</label>
                        <select class="form-select" id="status_magang" name="status_magang">
                            <option value="Aktif" {{ $magang->status_magang == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ $magang->status_magang == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="selesai" {{ $magang->status_magang == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $magang->status_magang == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <div class="form-text">Status ini menentukan akses mahasiswa ke sistem.</div>
                    </div>

                    <div class="mb-3">
                        <label for="target_book_mingguan" class="form-label">Target Logbook Mingguan</label>
                        <input type="number" class="form-control" id="target_book_mingguan" name="target_book_mingguan" value="{{ $magang->target_book_mingguan }}" min="1" max="7">
                        <div class="form-text">Jumlah logbook yang wajib diisi mahasiswa per minggu (Default: 5 hari kerja).</div>
                    </div>

                    <div class="mb-3">
                        <label for="tugas_description" class="form-label">Deskripsi Tugas</label>
                        <textarea class="form-control" id="tugas_description" name="tugas_description" rows="4" placeholder="Jelaskan tugas-tugas yang harus dilakukan peserta magang di unit ini">{{ $magang->tugas_description }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
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
    function toggleOtherUnit(value) {
        const otherGroup = document.getElementById('otherUnitGroup');
        const otherInput = document.getElementById('unit_lainnya');
        if (value === 'lainnya') {
            otherGroup.style.display = 'block';
            otherInput.required = true;
        } else {
            otherGroup.style.display = 'none';
            otherInput.required = false;
        }
    }
</script>
@endpush
