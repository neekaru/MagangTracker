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
                    <tr>
                        <td>Siti Aminah</td>
                        <td>C030320005</td>
                        <td>IT Support</td>
                        <td>Ganjil 2025/2026</td>
                        <td><span class="badge bg-danger">3</span></td>
                        <td>
                            <a href="{{ url('/pembimbing/peserta/1') }}" class="btn btn-sm btn-primary"><i class="fas fa-user"></i> Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Budi Santoso</td>
                        <td>C030320008</td>
                        <td>IT Support</td>
                        <td>Ganjil 2025/2026</td>
                        <td><span class="badge bg-secondary">0</span></td>
                        <td>
                            <a href="{{ url('/pembimbing/peserta/2') }}" class="btn btn-sm btn-primary"><i class="fas fa-user"></i> Detail</a>
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
        $('#pesertaTable').DataTable();
    });
</script>
@endpush
