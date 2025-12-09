@extends('layouts.app')

@section('title', 'Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Rekap Absensi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('mahasiswa.absensi.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-clock"></i> Isi Absensi
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="absensiTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Absensi</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensis as $absen)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}</td>
                        <td>
                            @if($absen->jenis_absen == 'masuk')
                                <span class="badge bg-primary">Masuk</span>
                            @else
                                <span class="badge bg-secondary">Pulang</span>
                            @endif
                        </td>
                        <td>{{ $absen->jam ?: '-' }}</td>
                        <td>
                            @if($absen->status_kehadiran == 'Hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif($absen->status_kehadiran == 'Izin')
                                <span class="badge bg-warning text-dark">Izin</span>
                            @else
                                <span class="badge bg-danger">Sakit</span>
                            @endif
                        </td>
                        <td>{{ $absen->keterangan ?: '-' }}</td>
                        <td>{{ $absen->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#absensiTable').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>
@endpush
