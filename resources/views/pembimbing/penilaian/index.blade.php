@extends('layouts.app')

@section('title', 'Input Penilaian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Input Penilaian Peserta</h1>
</div>

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
                    <tr>
                        <td>Siti Aminah</td>
                        <td>C030320005</td>
                        <td>IT Support</td>
                        <td><span class="badge bg-warning text-dark">Belum Dinilai</span></td>
                        <td>
                            <a href="{{ url('/pembimbing/penilaian/1') }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Nilai</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Budi Santoso</td>
                        <td>C030320008</td>
                        <td>IT Support</td>
                        <td><span class="badge bg-success">Sudah Dinilai</span></td>
                        <td>
                            <a href="{{ url('/pembimbing/penilaian/2') }}" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i> Edit</a>
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
        $('#penilaianTable').DataTable();
    });
</script>
@endpush
