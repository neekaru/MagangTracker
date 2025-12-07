@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Penilaian: {{ $penilaian->magang->mahasiswa->nama_lengkap ?? $penilaian->magang->mahasiswa->user->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('penilaian.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-sm btn-warning ms-2">
            <i class="fas fa-edit"></i> Edit Nilai
        </a>
        <button class="btn btn-sm btn-info ms-2" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h1 class="display-1 fw-bold text-primary">{{ number_format($rataRata, 1) }}</h1>
                <p class="lead">Nilai Akhir</p>
                @if($rataRata >= 60)
                    <span class="badge bg-success fs-5">LULUS</span>
                @else
                    <span class="badge bg-danger fs-5">TIDAK LULUS</span>
                @endif
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">Informasi Peserta</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th width="100">Nama</th>
                        <td>{{ $penilaian->magang->mahasiswa->nama_lengkap ?? $penilaian->magang->mahasiswa->user->name }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $penilaian->magang->mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Unit</th>
                        <td>{{ $penilaian->magang->unitBisnis->nama_unit_bisnis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>{{ $penilaian->magang->periodeMagang->nama_periode ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pembimbing</th>
                        <td>{{ $penilaian->penilai->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $penilaian->created_at->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Rincian Nilai</h6>
            </div>
            <div class="card-body">
                <h5 class="card-title">Komponen Penilaian</h5>
                <table class="table table-sm table-bordered mb-4">
                    <thead class="table-light">
                        <tr>
                            <th>Komponen</th>
                            <th width="20%" class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kedisiplinan</td>
                            <td class="text-center fw-bold">{{ $penilaian->nilai_kedisplinan }}</td>
                        </tr>
                        <tr>
                            <td>Tanggung Jawab</td>
                            <td class="text-center fw-bold">{{ $penilaian->nilai_tanggung_jawab }}</td>
                        </tr>
                        <tr>
                            <td>Kemampuan Teknis</td>
                            <td class="text-center fw-bold">{{ $penilaian->nilai_kemampuan_teknis }}</td>
                        </tr>
                        <tr>
                            <td>Laporan Akhir</td>
                            <td class="text-center fw-bold">{{ $penilaian->nilai_laporan_akhir }}</td>
                        </tr>
                        <tr>
                            <td>Prestasi</td>
                            <td class="text-center fw-bold">{{ $penilaian->nilai_prestasi }}</td>
                        </tr>
                        <tr class="table-primary fw-bold">
                            <td>Rata-rata</td>
                            <td class="text-center fs-5">{{ number_format($rataRata, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="alert alert-info">
                    <strong>Grade:</strong>
                    @php
                        if ($rataRata >= 85) {
                            echo 'A (Sangat Baik)';
                        } elseif ($rataRata >= 75) {
                            echo 'B (Baik)';
                        } elseif ($rataRata >= 65) {
                            echo 'C (Cukup)';
                        } elseif ($rataRata >= 55) {
                            echo 'D (Kurang)';
                        } else {
                            echo 'E (Sangat Kurang)';
                        }
                    @endphp
                </div>
            </div>
        </div>
        
        @if($penilaian->catatan)
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">Catatan Pembimbing</h6>
            </div>
            <div class="card-body">
                <blockquote class="blockquote">
                    <p>{{ $penilaian->catatan }}</p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    {{ $penilaian->penilai->nama_lengkap ?? 'Dosen Pembimbing' }}
                </figcaption>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
