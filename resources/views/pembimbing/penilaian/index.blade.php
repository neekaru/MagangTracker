@extends('layouts.app')

@section('title', 'Input Penilaian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Input Penilaian Peserta</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="penilaianTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>NIM</th>
                        <th>Unit</th>
                        <th>Status Penilaian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($magangList as $magang)
                    @php
                        $penilaian = $penilaianList->where('magang_id', $magang->id)->first();
                    @endphp
                    <tr>
                        <td>{{ $magang->mahasiswa->nama_lengkap ?? $magang->mahasiswa->user->name }}</td>
                        <td>{{ $magang->mahasiswa->nim }}</td>
                        <td>{{ $magang->unitBisnis->nama_unit_bisnis ?? '-' }}</td>
                        <td>
                            @if($penilaian)
                                <span class="badge bg-success">Sudah Dinilai</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Dinilai</span>
                            @endif
                        </td>
                        <td>
                            @if($penilaian)
                                <a href="{{ route('pembimbing.penilaian.show', $penilaian->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('pembimbing.penilaian.edit', $penilaian->id) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @else
                                <a href="{{ route('pembimbing.penilaian.create', $magang->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Nilai
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada peserta magang yang dibimbing</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#penilaianTable').DataTable();
    });
</script>
@endpush
