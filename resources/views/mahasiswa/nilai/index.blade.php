@extends('layouts.app')

@section('title', 'Nilai Akhir Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Nilai Akhir Magang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-sm btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Transkrip
        </button>
    </div>
</div>

@if($penilaian)
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h6 class="text-muted mb-3">Nilai Akhir</h6>
                <h1 class="display-1 fw-bold text-primary">{{ number_format($rataRata, 1) }}</h1>
                @if($rataRata >= 60)
                    <span class="badge bg-success fs-5 mt-2">LULUS</span>
                @else
                    <span class="badge bg-danger fs-5 mt-2">TIDAK LULUS</span>
                @endif
            </div>
        </div>

        @if($magang)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">Informasi Magang</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th width="120">Unit Bisnis</th>
                        <td>{{ $magang->unitBisnis->nama_unit_bisnis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>{{ \Carbon\Carbon::parse($magang->tanggal_mulai)->format('d/m/Y') }} - 
                            {{ \Carbon\Carbon::parse($magang->tanggal_selesai)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Pembimbing</th>
                        <td>{{ $magang->dosen->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dinilai pada</th>
                        <td>{{ $penilaian->created_at->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Rincian Penilaian</h6>
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
                        <tr class="fw-bold table-primary">
                            <td>Rata-rata</td>
                            <td class="text-center fs-5">{{ number_format($rataRata, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="alert alert-info">
                    <strong>Grade Nilai:</strong>
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
                <figure>
                    <blockquote class="blockquote">
                        <p>{{ $penilaian->catatan }}</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        {{ $penilaian->penilai->nama_lengkap ?? 'Dosen Pembimbing' }}
                    </figcaption>
                </figure>
            </div>
        </div>
        @endif
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> 
    Nilai Anda belum tersedia. Silakan hubungi dosen pembimbing Anda untuk informasi lebih lanjut.
    
    @if($magang)
        <hr>
        <strong>Informasi Magang Anda:</strong><br>
        Unit Bisnis: {{ $magang->unitBisnis->nama_unit_bisnis ?? '-' }}<br>
        Dosen Pembimbing: {{ $magang->dosen->nama_lengkap ?? '-' }}<br>
        Periode: {{ \Carbon\Carbon::parse($magang->tanggal_mulai)->format('d/m/Y') }} - 
                 {{ \Carbon\Carbon::parse($magang->tanggal_selesai)->format('d/m/Y') }}
    @endif
</div>
@endif
@endsection
