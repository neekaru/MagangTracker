@extends('layouts.app')

@section('title', 'Detail Peserta')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Peserta: {{ $peserta->mahasiswa->nama_lengkap ?? 'N/A' }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('pembimbing.peserta.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($peserta->mahasiswa->nama_lengkap ?? 'N/A') }}&background=random"
                        class="rounded-circle mb-3" width="100">
                    <h5>{{ $peserta->mahasiswa->nama_lengkap ?? 'N/A' }}</h5>
                    <p class="text-muted mb-1">{{ $peserta->mahasiswa->nim ?? 'N/A' }}</p>
                    <p class="badge bg-primary">{{ $peserta->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Statistik Magang</h5>
                    <div class="row text-center mt-4">
                        <div class="col-4">
                            @php
                                $totalAbsen = $peserta->absen->count();
                                $hadir = $peserta->absen->where('status_absensi', 'Hadir')->count();
                                $kehadiranPersen = $totalAbsen > 0 ? round(($hadir / $totalAbsen) * 100) : 0;
                            @endphp
                            <h3>{{ $kehadiranPersen }}%</h3>
                            <p class="text-muted">Kehadiran</p>
                        </div>
                        <div class="col-4">
                            @php
                                $logbookDisetujui = $peserta->logbook->where('status', 'approved')->count();
                            @endphp
                            <h3>{{ $logbookDisetujui }}</h3>
                            <p class="text-muted">Jurnal Kegiatan Disetujui</p>
                        </div>
                        <div class="col-4">
                            @php
                                $logbookPending = $peserta->logbook->where('status', 'pending')->count();
                            @endphp
                            <h3>{{ $logbookPending }}</h3>
                            <p class="text-muted">Jurnal Kegiatan Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="detailTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="logbook-tab" data-bs-toggle="tab" data-bs-target="#logbook"
                        type="button">Jurnal Kegiatan</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi"
                        type="button">Absensi</button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="detailTabContent">
                <!-- Logbook Tab -->
                <div class="tab-pane fade show active" id="logbook" role="tabpanel">
                    <table class="table table-striped w-100" id="logbookTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peserta->logbook->sortByDesc('tanggal') as $log)
                                <tr>
                                    <td>{{ $log->tanggal->format('d M Y') }}</td>
                                    @php
                                        $allowedTags = '<p><br><b><strong><i><em><u><ul><ol><li><a>';
                                        $kegiatanHtml = strip_tags($log->kegiatan ?? '', $allowedTags);
                                        $kegiatanHtml = preg_replace('/\son\w+="[^"]*"/i', '', $kegiatanHtml);
                                        $kegiatanHtml = preg_replace("/\son\w+='[^']*'/i", '', $kegiatanHtml);
                                        $kegiatanHtml = preg_replace('/href=("|\')\s*javascript:[^"\']*\1/i', 'href="#"', $kegiatanHtml);
                                    @endphp
                                    <td>{!! $kegiatanHtml !!}</td>
                                    <td>
                                        @if ($log->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($log->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada jurnal kegiatan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Absensi Tab -->
                <div class="tab-pane fade" id="absensi" role="tabpanel">
                    <table class="table table-striped w-100" id="absensiTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peserta->absen->sortByDesc('tanggal') as $absen)
                                <tr>
                                    <td>{{ $absen->tanggal->format('d M Y') }}</td>
                                    <td>{{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '-' }}</td>
                                    <td>{{ $absen->status_absensi }}</td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data absensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTables only if table has actual data rows (not empty state)
            var logbookRows = $('#logbookTable tbody tr:not(:has(td[colspan]))');
            if (logbookRows.length > 0) {
                $('#logbookTable').DataTable();
            }

            var absensiRows = $('#absensiTable tbody tr:not(:has(td[colspan]))');
            if (absensiRows.length > 0) {
                $('#absensiTable').DataTable();
            }
        });
    </script>
@endpush
