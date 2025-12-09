@extends('layouts.app')

@section('title', 'Validasi Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Validasi Absensi Peserta Bimbingan</h1>
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
            <table id="pembimbingAbsensiTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Jenis</th>
                        <th>Status Input</th>
                        <th>Status Validasi</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Validasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensis as $absen)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}</td>
                        <td>{{ $absen->magang->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                        <td>
                            @if($absen->jenis_absen == 'masuk')
                                <span class="badge bg-primary">Masuk</span>
                            @else
                                <span class="badge bg-secondary">Pulang</span>
                            @endif
                        </td>
                        <td>
                            @if($absen->status_kehadiran == 'Hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif($absen->status_kehadiran == 'Izin')
                                <span class="badge bg-warning text-dark">Izin</span>
                            @else
                                <span class="badge bg-danger">Sakit</span>
                            @endif
                        </td>
                        <td>
                            @if($absen->status_validasi === 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($absen->status_validasi === 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </td>
                        <td>{{ $absen->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</td>
                        <td>{{ $absen->keterangan ?: '-' }}</td>
                        <td>
                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                <a href="{{ route('pembimbing.absensi.show', $absen->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fas fa-eye"></i> Show
                                </a>
                                <form action="{{ route('pembimbing.absensi.update', $absen->id) }}" method="POST" class="d-flex gap-2 align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <select name="status_validasi" class="form-select form-select-sm" style="width: auto;">
                                        <option value="pending" @selected($absen->status_validasi == 'pending')>Menunggu</option>
                                        <option value="approved" @selected($absen->status_validasi == 'approved')>Setujui</option>
                                        <option value="rejected" @selected($absen->status_validasi == 'rejected')>Tolak</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </div>
                        </td>
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
        $('#pembimbingAbsensiTable').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>
@endpush
