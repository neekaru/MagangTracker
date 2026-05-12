@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Generate Laporan Mahasiswa Magang</h1>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Laporan Global</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laporan.export-pdf') }}" method="GET" id="laporanForm">
                        <div class="row">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-building"></i> Unit Bisnis</label>
                                    <select class="form-select" name="unit_bisnis_id">
                                        <option value="">Semua Unit Bisnis</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->nama_unit_bisnis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-user-tie"></i> Dosen Pembimbing</label>
                                    <select class="form-select" name="dosen_id">
                                        <option value="">Semua Dosen</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}">{{ $dosen->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-info-circle"></i> Status Magang</label>
                                    <select class="form-select" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Nonaktif">Nonaktif</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-calendar"></i> Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                                    <small class="text-muted">Filter absensi & logbook dari tanggal ini</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-calendar"></i> Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                                    <small class="text-muted">Filter absensi & logbook sampai tanggal ini</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger btn-lg"
                                formaction="{{ route('admin.laporan.export-pdf') }}">
                                <i class="fas fa-file-pdf"></i> Download Laporan PDF
                            </button>
                            <button type="submit" class="btn btn-success btn-lg"
                                formaction="{{ route('admin.laporan.export-excel') }}">
                                <i class="fas fa-file-excel"></i> Download Laporan Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle"></i> Informasi</h5>
                <p class="mb-2 small">Laporan Admin mencakup:</p>
                <ul class="mb-0 small">
                    <li>Seluruh data mahasiswa magang</li>
                    <li>Rekap absensi global</li>
                    <li>Rekap logbook global</li>
                    <li>Statistik kehadiran</li>
                    <li>Status validasi</li>
                    <li>Persentase kehadiran per mahasiswa</li>
                </ul>
            </div>

            <div class="alert alert-success">
                <h5><i class="fas fa-chart-bar"></i> Statistik</h5>
                <p class="mb-0 small">Laporan akan menampilkan:</p>
                <ul class="mb-0 small">
                    <li>Total mahasiswa aktif</li>
                    <li>Total kehadiran</li>
                    <li>Total izin & sakit</li>
                    <li>Total logbook</li>
                    <li>Status validasi</li>
                </ul>
            </div>

            <div class="alert alert-warning">
                <h5><i class="fas fa-exclamation-triangle"></i> Catatan</h5>
                <ul class="mb-0 small">
                    <li>Semua filter bersifat opsional</li>
                    <li>Filter tanggal untuk absensi & logbook</li>
                    <li>Excel memiliki 3 sheet terpisah</li>
                    <li>PDF format landscape</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
