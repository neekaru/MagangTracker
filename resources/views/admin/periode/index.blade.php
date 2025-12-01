@extends('layouts.app')

@section('title', 'Periode Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Periode Magang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Periode
        </button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="periodeTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Periode</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Semester Ganjil 2025/2026</td>
                        <td>01 Sep 2025</td>
                        <td>31 Jan 2026</td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Semester Genap 2024/2025</td>
                        <td>01 Feb 2025</td>
                        <td>31 Jul 2025</td>
                        <td><span class="badge bg-secondary">Nonaktif</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
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
        $('#periodeTable').DataTable();
    });
</script>
@endpush
