@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Generate Laporan Mahasiswa Magang</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pembimbing.laporan.export-pdf') }}" method="GET" id="laporanForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-user-graduate"></i> Mahasiswa</label>
                                    <select class="form-select" name="mahasiswa_id" required>
                                        <option value="">-- Pilih Mahasiswa --</option>
                                        @foreach ($magangs as $magang)
                                            <option value="{{ $magang->mahasiswa->id }}">
                                                {{ $magang->mahasiswa->nim }} - {{ $magang->mahasiswa->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Wajib pilih mahasiswa untuk generate laporan</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-calendar-alt"></i> Periode Magang</label>
                                    <select class="form-select" name="periode_id">
                                        <option value="">Semua Periode</option>
                                        @foreach ($periodes as $periode)
                                            <option value="{{ $periode->id }}">{{ $periode->nama_periode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-calendar"></i> Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                                    <small class="text-muted">Filter data dari tanggal ini</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-calendar"></i> Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                                    <small class="text-muted">Filter data sampai tanggal ini</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-check-circle"></i> Status Keabsahan Absensi</label>
                                    <select class="form-select" name="status_validasi_absensi">
                                        <option value="">Semua Status</option>
                                        <option value="pending">Menunggu (sinkron logbook)</option>
                                        <option value="approved">Disetujui (sinkron logbook)</option>
                                        <option value="rejected">Ditolak (sinkron logbook)</option>
                                    </select>
                                    <small class="text-muted">Status ini mengikuti approval logbook harian pembimbing.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-book"></i> Status Validasi Logbook</label>
                                    <select class="form-select" name="status_validasi_logbook">
                                        <option value="">Semua Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger btn-lg"
                                formaction="{{ route('pembimbing.laporan.export-pdf') }}">
                                <i class="fas fa-file-pdf"></i> Download Laporan PDF
                            </button>
                            <button type="submit" class="btn btn-success btn-lg"
                                formaction="{{ route('pembimbing.laporan.export-excel') }}">
                                <i class="fas fa-file-excel"></i> Download Laporan Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle"></i> Informasi Laporan</h5>
                <p class="mb-2">Laporan ini mencakup:</p>
                <ul class="mb-0 small">
                    <li>Informasi mahasiswa lengkap</li>
                    <li>Rekap absensi harian</li>
                    <li>Rekap jurnal kegiatan</li>
                    <li>Statistik kehadiran</li>
                    <li>Koordinat GPS lokasi absensi</li>
                </ul>
            </div>

            <div class="alert alert-warning">
                <h5><i class="fas fa-exclamation-triangle"></i> Catatan</h5>
                <ul class="mb-0 small">
                    <li>Pilih mahasiswa terlebih dahulu</li>
                    <li>Filter tanggal bersifat opsional</li>
                    <li>Laporan dapat diekspor ke PDF atau Excel</li>
                    <li>Foto bukti hanya muncul di PDF</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
