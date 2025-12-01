@extends('layouts.app')

@section('title', 'Manajemen Users')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Users</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/users/create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="usersTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Email / Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dummy Data -->
                    <tr>
                        <td>1</td>
                        <td>Admin Utama</td>
                        <td>admin@example.com</td>
                        <td><span class="badge bg-danger">Admin</span></td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Budi Santoso</td>
                        <td>budi@dosen.com</td>
                        <td><span class="badge bg-info text-dark">Pembimbing</span></td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Siti Aminah</td>
                        <td>siti@mhs.com</td>
                        <td><span class="badge bg-secondary">Mahasiswa</span></td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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
        $('#usersTable').DataTable();
    });
</script>
@endpush
