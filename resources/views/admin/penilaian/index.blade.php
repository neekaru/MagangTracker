@extends('layouts.app')

@section('title', 'Penilaian Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Penilaian Akhir Magang</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="penilaianTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Unit</th>
                        <th>Pembimbing</th>
                        <th>Nilai Lapangan</th>
                        <th>Nilai Dosen</th>
                        <th>Nilai Akhir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Siti Aminah</td>
                        <td>IT Support</td>
                        <td>Pak Budi</td>
                        <td>85</td>
                        <td>90</td>
                        <td><strong>87.5</strong></td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td>
                            <a href="{{ url('/admin/penilaian/1') }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                            <a href="{{ url('/admin/penilaian/1/edit') }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Rudi Hartono</td>
                        <td>Keuangan</td>
                        <td>Bu Ani</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><span class="badge bg-warning text-dark">Proses</span></td>
                        <td>
                            <a href="{{ url('/admin/penilaian/2') }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                            <a href="{{ url('/admin/penilaian/2/edit') }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
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
