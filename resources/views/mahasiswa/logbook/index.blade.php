@extends('layouts.app')

@section('title', 'Logbook Harian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Logbook Harian</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/mahasiswa/logbook/create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Isi Logbook
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="logbookTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Kegiatan</th>
                        <th>Output</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logbooks as $logbook)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($logbook->tanggal_logbook)->format('d M Y') }}</td>
                        <td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
                        <td>{{ Str::limit($logbook->deskripsi_kegiatan, 50) }}</td>
                        <td>{{ Str::limit($logbook->hasil_kegiatan, 30) }}</td>
                        <td>
                            @if($logbook->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($logbook->status == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($logbook->status == 'pending')
                                <a href="{{ route('logbook.edit', $logbook) }}" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></a>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled><i class="fas fa-edit"></i></button>
                            @endif
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
        $('#logbookTable').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>
@endpush
