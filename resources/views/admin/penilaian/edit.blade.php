@extends('layouts.app')

@section('title', 'Edit Penilaian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Penilaian: {{ $penilaian->magang->mahasiswa->nama_lengkap ?? $penilaian->magang->mahasiswa->user->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0">Informasi Peserta</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th width="150">Nama</th>
                        <td>{{ $penilaian->magang->mahasiswa->nama_lengkap ?? $penilaian->magang->mahasiswa->user->name }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $penilaian->magang->mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Unit Bisnis</th>
                        <td>{{ $penilaian->magang->unitBisnis->nama_unit_bisnis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pembimbing</th>
                        <td>{{ $penilaian->penilai->nama_lengkap ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('penilaian.update', $penilaian->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h5 class="mb-3">Komponen Penilaian</h5>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Kedisiplinan <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control @error('nilai_kedisplinan') is-invalid @enderror" 
                                   name="nilai_kedisplinan" min="0" max="100" 
                                   value="{{ old('nilai_kedisplinan', $penilaian->nilai_kedisplinan) }}" required>
                            @error('nilai_kedisplinan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Tanggung Jawab <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control @error('nilai_tanggung_jawab') is-invalid @enderror" 
                                   name="nilai_tanggung_jawab" min="0" max="100" 
                                   value="{{ old('nilai_tanggung_jawab', $penilaian->nilai_tanggung_jawab) }}" required>
                            @error('nilai_tanggung_jawab')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Kemampuan Teknis <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control @error('nilai_kemampuan_teknis') is-invalid @enderror" 
                                   name="nilai_kemampuan_teknis" min="0" max="100" 
                                   value="{{ old('nilai_kemampuan_teknis', $penilaian->nilai_kemampuan_teknis) }}" required>
                            @error('nilai_kemampuan_teknis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Laporan Akhir <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control @error('nilai_laporan_akhir') is-invalid @enderror" 
                                   name="nilai_laporan_akhir" min="0" max="100" 
                                   value="{{ old('nilai_laporan_akhir', $penilaian->nilai_laporan_akhir) }}" required>
                            @error('nilai_laporan_akhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Prestasi <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control @error('nilai_prestasi') is-invalid @enderror" 
                                   name="nilai_prestasi" min="0" max="100" 
                                   value="{{ old('nilai_prestasi', $penilaian->nilai_prestasi) }}" required>
                            @error('nilai_prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label fw-bold text-primary">Nilai Rata-rata</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control-plaintext fw-bold text-primary" 
                                   id="nilai_akhir" value="0" readonly>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan / Komentar</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  id="catatan" name="catatan" rows="4">{{ old('catatan', $penilaian->catatan) }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <h6>Panduan Penilaian</h6>
                <ul class="small text-muted ps-3 mb-0">
                    <li>Rentang nilai: 0 - 100</li>
                    <li>Nilai rata-rata dihitung otomatis</li>
                    <li>Grade: A (≥85), B (≥75), C (≥65), D (≥55), E (<55)</li>
                    <li>Semua field wajib diisi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function calculateAverage() {
            let kedisplinan = parseFloat($('input[name=nilai_kedisplinan]').val()) || 0;
            let tanggungJawab = parseFloat($('input[name=nilai_tanggung_jawab]').val()) || 0;
            let teknis = parseFloat($('input[name=nilai_kemampuan_teknis]').val()) || 0;
            let laporan = parseFloat($('input[name=nilai_laporan_akhir]').val()) || 0;
            let prestasi = parseFloat($('input[name=nilai_prestasi]').val()) || 0;
            
            let average = (kedisplinan + tanggungJawab + teknis + laporan + prestasi) / 5;
            
            $('#nilai_akhir').val(average.toFixed(2));
        }
        
        $('input[type=number]').on('input', calculateAverage);
        calculateAverage();
    });
</script>
@endpush
