@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit User</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (Opsional)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <small class="text-muted">Minimal 6 karakter jika diisi</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                                required>
                                <option value="">Pilih Role...</option>
                                <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="Pembimbing" {{ old('role', $user->role) == 'Pembimbing' ? 'selected' : '' }}>
                                    Pembimbing</option>
                                <option value="Mahasiswa" {{ old('role', $user->role) == 'Mahasiswa' ? 'selected' : '' }}>
                                    Mahasiswa</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fields for Pembimbing -->
                        <div id="pembimbingFields" style="display: none;">
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    id="nama_lengkap" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $user->dosen->nama_lengkap ?? '') }}">
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP (Opsional)</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                    name="nip" value="{{ old('nip', $user->dosen->nip ?? '') }}">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fields for Mahasiswa -->
                        <div id="mahasiswaFields" style="display: none;">
                            <div class="mb-3">
                                <label for="nama_lengkap_mhs" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    id="nama_lengkap_mhs" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $user->mahasiswa->nama_lengkap ?? '') }}">
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nim') is-invalid @enderror"
                                    id="nim" name="nim" value="{{ old('nim', $user->mahasiswa->nim ?? '') }}">
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                    id="tanggal_mulai" name="tanggal_mulai"
                                    value="{{ old('tanggal_mulai', $user->mahasiswa ? $user->mahasiswa->tanggal_mulai->format('Y-m-d') : '') }}">
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                    id="tanggal_selesai" name="tanggal_selesai"
                                    value="{{ old('tanggal_selesai', $user->mahasiswa ? $user->mahasiswa->tanggal_selesai->format('Y-m-d') : '') }}">
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Show/hide fields based on role
            function toggleFields() {
                const role = $('#role').val();

                $('#pembimbingFields').hide();
                $('#mahasiswaFields').hide();

                if (role === 'Pembimbing') {
                    $('#pembimbingFields').show();
                } else if (role === 'Mahasiswa') {
                    $('#mahasiswaFields').show();
                }
            }

            $('#role').change(toggleFields);

            // Trigger on page load
            toggleFields();
        });
    </script>
@endpush
