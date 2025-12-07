@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Penilaian: {{ $penilaian->magang->mahasiswa->nama_lengkap ?? $penilaian->magang->mahasiswa->user->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('pembimbing.penilaian.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('pembimbing.penilaian.edit', $penilaian->id) }}" class="btn btn-sm btn-primary ms-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        <button class="btn btn-sm btn-info ms-2" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0">Informasi Peserta</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th width="180">Nama</th>
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
                        <th>Periode</th>
                        <td>{{ $penilaian->magang->tanggal_mulai }} s/d {{ $penilaian->magang->tanggal_selesai }}</td>
                    </tr>
                    <tr>
                        <th>Dinilai oleh</th>
                        <td>{{ $penilaian->penilai->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Penilaian</th>
                        <td>{{ $penilaian->created_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Hasil Penilaian</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="50%" class="text-center">Komponen Penilaian</th>
                            <th class="text-center">Nilai</th>
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
                        <tr class="table-primary">
                            <td class="fw-bold">Nilai Rata-rata</td>
                            <td class="text-center fw-bold fs-5">
                                @php
                                    $average = ($penilaian->nilai_kedisplinan + 
                                               $penilaian->nilai_tanggung_jawab + 
                                               $penilaian->nilai_kemampuan_teknis + 
                                               $penilaian->nilai_laporan_akhir + 
                                               $penilaian->nilai_prestasi) / 5;
                                @endphp
                                {{ number_format($average, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if($penilaian->catatan)
                <div class="mt-4">
                    <h6>Catatan / Komentar:</h6>
                    <div class="alert alert-light">
                        {{ $penilaian->catatan }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">Grade Penilaian</h6>
            </div>
            <div class="card-body text-center">
                @php
                    $average = ($penilaian->nilai_kedisplinan + 
                               $penilaian->nilai_tanggung_jawab + 
                               $penilaian->nilai_kemampuan_teknis + 
                               $penilaian->nilai_laporan_akhir + 
                               $penilaian->nilai_prestasi) / 5;
                    
                    if ($average >= 85) {
                        $grade = 'A';
                        $gradeClass = 'success';
                    } elseif ($average >= 75) {
                        $grade = 'B';
                        $gradeClass = 'primary';
                    } elseif ($average >= 65) {
                        $grade = 'C';
                        $gradeClass = 'warning';
                    } elseif ($average >= 55) {
                        $grade = 'D';
                        $gradeClass = 'danger';
                    } else {
                        $grade = 'E';
                        $gradeClass = 'dark';
                    }
                @endphp
                
                <h1 class="display-1 text-{{ $gradeClass }}">{{ $grade }}</h1>
                <p class="text-muted">Grade Nilai</p>
                <hr>
                <div class="text-start">
                    <small class="text-muted">
                        <strong>Keterangan:</strong><br>
                        A: 85-100 (Sangat Baik)<br>
                        B: 75-84 (Baik)<br>
                        C: 65-74 (Cukup)<br>
                        D: 55-64 (Kurang)<br>
                        E: 0-54 (Sangat Kurang)
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
