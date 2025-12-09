@extends('layouts.app')

@section('title', 'Mahasiswa Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h2>Halo, Mahasiswa!</h2>
            <p>Selamat datang di dashboard magang anda.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><i class="fas fa-check-circle me-2"></i>Status Magang</div>
                <div class="card-body text-center">
                    <h5 class="card-title">Status Magang <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip"
                            title="Status resmi kepesertaan magang Anda."></i></h5>
                    <p class="display-6 @if($status_magang == 'Aktif') text-success @elseif($status_magang == 'Pending') text-warning @else text-secondary @endif"><i
                            class="fas fa-check-circle"></i> {{ $status_magang }}</p>
                    <p class="text-muted">Unit: {{ $unit_penempatan }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><i class="fas fa-clock me-2"></i>Kehadiran</div>
                <div class="card-body text-center">
                    <h5 class="card-title">Kehadiran <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip"
                            title="Persentase kehadiran berdasarkan hari kerja yang telah berjalan."></i></h5>
                    <p class="display-6 text-primary">{{ $kehadiran_persen }}%</p>
                    <p class="text-muted">Total {{ $kehadiran_total }}/{{ $kehadiran_max }} Hari</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><i class="fas fa-book me-2"></i>Logbook Minggu Ini</div>
                <div class="card-body text-center">
                    <h5 class="card-title">Logbook Minggu Ini <i class="fas fa-info-circle text-muted"
                            data-bs-toggle="tooltip" title="Jumlah logbook yang telah diisi pada minggu ini."></i></h5>
                    <p class="display-6 text-warning">{{ $logbook_minggu_ini }}/{{ $logbook_target }}</p>
                    <a href="{{ url('/mahasiswa/logbook/create') }}" class="btn btn-sm btn-primary">Isi Logbook</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-book me-2"></i>Logbook Terakhir</div>
                @if($latest_logbook->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($latest_logbook as $logbook)
                            <li class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $logbook->tanggal_logbook->translatedFormat('l, d M Y') }}</h6>
                                    <small class="text-muted">{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</small>
                                </div>
                                <p class="mb-1">{{ $logbook->deskripsi_kegiatan }}</p>
                                @if($logbook->status == 'Disetujui')
                                    <small class="text-success">Disetujui</small>
                                @elseif($logbook->status == 'Ditolak')
                                    <small class="text-danger">Ditolak</small>
                                @else
                                    <small class="text-warning">Menunggu Persetujuan</small>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="card-body text-center text-muted">
                        <p class="mb-0">Belum ada logbook. <a href="{{ url('/mahasiswa/logbook/create') }}">Isi logbook sekarang</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
