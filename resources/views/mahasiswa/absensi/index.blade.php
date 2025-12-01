@extends('layouts.app')

@section('title', 'Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Rekap Absensi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/mahasiswa/absensi/create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-clock"></i> Isi Absensi
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="absensiTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Input</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01 Des 2025</td>
                        <td>07:55</td>
                        <td><span class="badge bg-success">Hadir</span></td>
                        <td>Masuk tepat waktu</td>
                        <td>Kantor Pusat</td>
                    </tr>
                    <tr>
                        <td>28 Nov 2025</td>
                        <td>08:05</td>
                        <td><span class="badge bg-success">Hadir</span></td>
                        <td>Agak terlambat macet</td>
                        <td>Kantor Pusat</td>
                    </tr>
                    <tr>
                        <td>27 Nov 2025</td>
                        <td>-</td>
                        <td><span class="badge bg-warning text-dark">Izin</span></td>
                        <td>Sakit Demam</td>
                        <td>-</td>
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
        $('#absensiTable').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>
@endpush
