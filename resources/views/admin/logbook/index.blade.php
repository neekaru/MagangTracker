@extends('layouts.app')

@section('title', 'Monitoring Logbook')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Monitoring Logbook Peserta</h1>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Periode</label>
                <select class="form-select">
                    <option selected>Semua Periode</option>
                    <option>Ganjil 2025/2026</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Unit</label>
                <select class="form-select">
                    <option selected>Semua Unit</option>
                    <option>IT Support</option>
                    <option>Keuangan</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="logbookTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Peserta</th>
                        <th>Unit</th>
                        <th>Kegiatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01 Des 2025</td>
                        <td>Siti Aminah</td>
                        <td>IT Support</td>
                        <td>Maintenance Server</td>
                        <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                        <td>
                            <button class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>01 Des 2025</td>
                        <td>Rudi Hartono</td>
                        <td>Keuangan</td>
                        <td>Input Data Transaksi</td>
                        <td><span class="badge bg-success">Disetujui</span></td>
                        <td>
                            <button class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></button>
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
