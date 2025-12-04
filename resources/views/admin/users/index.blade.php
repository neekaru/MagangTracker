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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if ($user->role === 'Pembimbing' && $user->dosen)
                                        {{ $user->dosen->nama_lengkap }}
                                    @elseif($user->role === 'Mahasiswa' && $user->mahasiswa)
                                        {{ $user->mahasiswa->nama_lengkap ?? 'NISN: ' . $user->mahasiswa->nisn }}
                                    @else
                                        Admin
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role === 'Admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->role === 'Pembimbing')
                                        <span class="badge bg-info text-dark">Pembimbing</span>
                                    @else
                                        <span class="badge bg-secondary">Mahasiswa</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info text-white"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data user</td>
                            </tr>
                        @endforelse
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

            $('.delete-btn').click(function() {
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>
@endpush
