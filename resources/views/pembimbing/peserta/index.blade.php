@extends('layouts.app')

@section('title', 'Peserta Bimbingan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Peserta Bimbingan</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="pesertaTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>NIM</th>
                        <th>Unit</th>
                        <th>Periode</th>
                        <th>Logbook (Pending)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesertas as $peserta)
                    <tr>
                        <td>{{ $peserta->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                        <td>{{ $peserta->mahasiswa->nim ?? 'N/A' }}</td>
                        <td>{{ $peserta->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</td>
                        <td>{{ $peserta->periodeMagang->nama_periode ?? 'N/A' }}</td>
                        <td>
                            @php
                                $pending = $peserta->logbook->where('status', 'pending')->count();
                            @endphp
                            @if($pending > 0)
                                <span class="badge bg-danger">{{ $pending }}</span>
                            @else
                                <span class="badge bg-secondary">0</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pembimbing.peserta.show', $peserta->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-user"></i> Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada peserta bimbingan.</td>
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
        $('#pesertaTable').DataTable();
    });
</script>
@endpush
