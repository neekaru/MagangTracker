@extends('layouts.app')

@section('title', 'Monitoring Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Monitoring Absensi Peserta</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-sm btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="absensiTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Peserta</th>
                        <th>Jam Masuk</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01 Des 2025</td>
                        <td>Siti Aminah</td>
                        <td>07:55</td>
                        <td><span class="badge bg-success">Hadir</span></td>
                        <td>-</td>
                        <td>Kantor Pusat</td>
                    </tr>
                    <tr>
                        <td>01 Des 2025</td>
                        <td>Rudi Hartono</td>
                        <td>08:10</td>
                        <td><span class="badge bg-success">Hadir</span></td>
                        <td>Terlambat</td>
                        <td>Gedung Keuangan</td>
                    </tr>
                    <tr>
                        <td>01 Des 2025</td>
                        <td>Dewi Sartika</td>
                        <td>-</td>
                        <td><span class="badge bg-danger">Sakit</span></td>
                        <td>Demam tinggi</td>
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
