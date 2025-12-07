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
                    
                    <div class="mb-3">
                        <label for="id_mahasiswa" class="form-label">Mahasiswa <span class="text-danger">*</span></label>
                        <input type="hidden" name="id_mahasiswa" value="{{ $magang->id_mahasiswa }}">
                        <input type="text" class="form-control" value="{{ $magang->mahasiswa->nama_lengkap ?? 'N/A' }} ({{ $magang->mahasiswa->nim ?? 'N/A' }})" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Unit Bisnis <span class="text-danger">*</span></label>
                        <select class="form-control @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id" required onchange="toggleUnitLainnya(this.value)">
                            <option value="">Pilih Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id', $magang->unit_id) == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama_unit_bisnis }}
                                </option>
                            @endforeach
                            <option value="lainnya" {{ old('unit_id', $magang->unit_id) == null && $magang->unit_lainnya ? 'selected' : '' }}>Unit Lainnya</option>
                        </select>
                        @error('unit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="unitLainnyaGroup" style="display: {{ old('unit_id', $magang->unit_id) == null && $magang->unit_lainnya ? 'block' : 'none' }};">
                        <label for="unit_lainnya" class="form-label">Unit Lainnya (Opsional)</label>
                        <input type="text" class="form-control @error('unit_lainnya') is-invalid @enderror" id="unit_lainnya" name="unit_lainnya" value="{{ old('unit_lainnya', $magang->unit_lainnya) }}">
                        @error('unit_lainnya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="periode_id" class="form-label">Periode Magang <span class="text-danger">*</span></label>
                        <select class="form-control @error('periode_id') is-invalid @enderror" id="periode_id" name="periode_id" required>
                            <option value="">Pilih Periode</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->id }}" {{ old('periode_id', $magang->periode_id) == $periode->id ? 'selected' : '' }}>
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
                                <option value="{{ $dosen->id }}" {{ old('id_dosen', $magang->id_dosen) == $dosen->id ? 'selected' : '' }}>
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
                        <input type="text" class="form-control @error('pembimbing_lapangan') is-invalid @enderror" id="pembimbing_lapangan" name="pembimbing_lapangan" value="{{ old('pembimbing_lapangan', $magang->pembimbing_lapangan) }}" required>
                        @error('pembimbing_lapangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $magang->tanggal_mulai->format('Y-m-d')) }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $magang->tanggal_selesai->format('Y-m-d')) }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status_magang" class="form-label">Status Magang <span class="text-danger">*</span></label>
                        <select class="form-control @error('status_magang') is-invalid @enderror" id="status_magang" name="status_magang" required>
                            <option value="Aktif" {{ old('status_magang', $magang->status_magang) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status_magang', $magang->status_magang) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="selesai" {{ old('status_magang', $magang->status_magang) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ old('status_magang', $magang->status_magang) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status_magang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tugas_description" class="form-label">Deskripsi Tugas <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('tugas_description') is-invalid @enderror" id="tugas_description" name="tugas_description" rows="4" required>{{ old('tugas_description', $magang->tugas_description) }}</textarea>
                        @error('tugas_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="target_book_mingguan" class="form-label">Target Logbook Mingguan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('target_book_mingguan') is-invalid @enderror" id="target_book_mingguan" name="target_book_mingguan" min="1" value="{{ old('target_book_mingguan', $magang->target_book_mingguan) }}" required>
                        @error('target_book_mingguan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('magang.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update Magang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleUnitLainnya(value) {
        const unitLainnyaGroup = document.getElementById('unitLainnyaGroup');
        const unitLainnyaInput = document.getElementById('unit_lainnya');
        
        if (value === 'lainnya') {
            unitLainnyaGroup.style.display = 'block';
            unitLainnyaInput.required = true;
        } else {
            unitLainnyaGroup.style.display = 'none';
            unitLainnyaInput.required = false;
            unitLainnyaInput.value = '';
        }
    }
</script>
@endpush
