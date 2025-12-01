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
                    <tr>
                        <td>01 Des 2025</td>
                        <td>08:00 - 16:00</td>
                        <td>Memperbaiki jaringan LAN di lantai 2.</td>
                        <td>Koneksi stabil</td>
                        <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>28 Nov 2025</td>
                        <td>08:00 - 16:00</td>
                        <td>Instalasi OS Windows pada PC baru.</td>
                        <td>PC Siap pakai</td>
                        <td><span class="badge bg-success">Disetujui</span></td>
                        <td>
                            <button class="btn btn-sm btn-secondary" disabled><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
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
