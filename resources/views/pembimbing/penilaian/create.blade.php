@extends('layouts.app')

@section('title', 'Tambah Penilaian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Form Penilaian: {{ $magang->mahasiswa->nama_lengkap ?? $magang->mahasiswa->user->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('pembimbing.penilaian.index') }}" class="btn btn-sm btn-secondary">
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
                        <td>{{ $magang->mahasiswa->nama_lengkap ?? $magang->mahasiswa->user->name }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $magang->mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Unit Bisnis</th>
                        <td>{{ $magang->unitBisnis->nama_unit_bisnis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>{{ $magang->tanggal_mulai }} s/d {{ $magang->tanggal_selesai }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('pembimbing.penilaian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="magang_id" value="{{ $magang->id }}">
                    
                    <h5 class="mb-3">Komponen Penilaian</h5>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Kedisiplinan <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control @error('nilai_kedisplinan') is-invalid @enderror" 
                                   name="nilai_kedisplinan" min="0" max="100" value="{{ old('nilai_kedisplinan') }}" required>
                            @error('nilai_kedisplinan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Tanggung Jawab <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control @error('nilai_tanggung_jawab') is-invalid @enderror" 
                                   name="nilai_tanggung_jawab" min="0" max="100" value="{{ old('nilai_tanggung_jawab') }}" required>
                            @error('nilai_tanggung_jawab')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Kemampuan Teknis <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control @error('nilai_kemampuan_teknis') is-invalid @enderror" 
                                   name="nilai_kemampuan_teknis" min="0" max="100" value="{{ old('nilai_kemampuan_teknis') }}" required>
                            @error('nilai_kemampuan_teknis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Laporan Akhir <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control @error('nilai_laporan_akhir') is-invalid @enderror" 
                                   name="nilai_laporan_akhir" min="0" max="100" value="{{ old('nilai_laporan_akhir') }}" required>
                            @error('nilai_laporan_akhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label">Prestasi <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control @error('nilai_prestasi') is-invalid @enderror" 
                                   name="nilai_prestasi" min="0" max="100" value="{{ old('nilai_prestasi') }}" required>
                            @error('nilai_prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Rata-rata Nilai</h5>
                    <div class="mb-3 row">
                        <label class="col-sm-5 col-form-label fw-bold text-primary">Nilai Rata-rata</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control-plaintext fw-bold text-primary" 
                                   id="nilai_akhir" value="0" readonly>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Catatan / Komentar</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  name="catatan" rows="4">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pembimbing.penilaian.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <h6>Panduan Penilaian</h6>
                <ul class="small text-muted ps-3">
                    <li>Rentang nilai 0 - 100</li>
                    <li>Nilai Rata-rata dihitung otomatis</li>
                    <li>Semua field wajib diisi</li>
                    <li>Pastikan objektif dalam memberikan penilaian</li>
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
