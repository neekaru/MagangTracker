@extends('layouts.app')

@section('title', 'Pengelolaan Pengumuman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pengelolaan Pengumuman</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/announcements/create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Buat Pengumuman Baru
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="announcementsTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pengumuman Libur Semester</td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>01 Des 2025</td>
                        <td>
                            <a href="{{ url('/admin/announcements/1/edit') }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(1)"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jadwal Seminar Magang</td>
                        <td><span class="badge bg-secondary">Tidak Aktif</span></td>
                        <td>28 Nov 2025</td>
                        <td>
                            <a href="{{ url('/admin/announcements/2/edit') }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(2)"><i class="fas fa-trash"></i></button>
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
        $('#announcementsTable').DataTable();
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Pengumuman ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Simulate delete
                Swal.fire('Dihapus!', 'Pengumuman telah dihapus.', 'success');
            }
        });
    }
</script>
@endpush