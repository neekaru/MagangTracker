@extends('layouts.app')

@section('title', 'Edit Data Magang')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Data Magang</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('magang.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('magang.update', $magang->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id_mahasiswa" class="form-label">Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <input type="hidden" name="id_mahasiswa" value="{{ $magang->id_mahasiswa }}">
                            <input type="text" class="form-control"
                                value="{{ $magang->mahasiswa->nama_lengkap ?? 'N/A' }} ({{ $magang->mahasiswa->nim ?? 'N/A' }})"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Unit Bisnis <span class="text-danger">*</span></label>
                            <select class="form-select @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id"
                                required>
                                <option value="">Pilih Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ old('unit_id', $magang->unit_id) == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->nama_unit_bisnis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="periode_id" class="form-label">Periode Magang <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('periode_id') is-invalid @enderror" id="periode_id"
                                name="periode_id" required>
                                <option value="">Pilih Periode</option>
                                @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}"
                                        {{ old('periode_id', $magang->periode_id) == $periode->id ? 'selected' : '' }}>
                                        {{ $periode->nama_periode }} ({{ $periode->tanggal_mulai->format('M Y') }} -
                                        {{ $periode->tanggal_selesai->format('M Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('periode_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_dosen" class="form-label">Dosen Pembimbing <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('id_dosen') is-invalid @enderror" id="id_dosen"
                                name="id_dosen" required>
                                <option value="">Pilih Dosen</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}"
                                        {{ old('id_dosen', $magang->id_dosen) == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_dosen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pembimbing_lapangan" class="form-label">Pembimbing Lapangan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pembimbing_lapangan') is-invalid @enderror"
                                id="pembimbing_lapangan" name="pembimbing_lapangan"
                                value="{{ old('pembimbing_lapangan', $magang->pembimbing_lapangan) }}" required>
                            @error('pembimbing_lapangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_magang" class="form-label">Status Magang <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('status_magang') is-invalid @enderror" id="status_magang"
                                name="status_magang" required>
                                <option value="Aktif"
                                    {{ old('status_magang', $magang->status_magang) == 'Aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="Nonaktif"
                                    {{ old('status_magang', $magang->status_magang) == 'Nonaktif' ? 'selected' : '' }}>
                                    Nonaktif</option>
                                <option value="Selesai"
                                    {{ old('status_magang', $magang->status_magang) == 'Selesai' ? 'selected' : '' }}>
                                    Selesai</option>
                            </select>
                            @error('status_magang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tugas_description" class="form-label">Deskripsi Tugas <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('tugas_description') is-invalid @enderror" id="tugas_description"
                                name="tugas_description" rows="4" required>{{ old('tugas_description', $magang->tugas_description) }}</textarea>
                            @error('tugas_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="target_book_mingguan" class="form-label">Target Logbook Mingguan <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('target_book_mingguan') is-invalid @enderror"
                                id="target_book_mingguan" name="target_book_mingguan" min="1"
                                value="{{ old('target_book_mingguan', $magang->target_book_mingguan) }}" required>
                            @error('target_book_mingguan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('magang.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Magang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Select2 CSS (stable) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom styles to emulate Bootstrap 5 look and fix arrow alignment -->
    <style>
        /* Make Select2 visually closer to Bootstrap 5 .form-select */
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + 1rem + 2px);
            /* similar to Bootstrap 5 form-select height */
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            /* rounded like bootstrap */
            background-color: #fff;
            display: block;
            position: relative;
            box-sizing: border-box;
        }

        /* Keep inner rendered content vertically centered */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            display: inline-block;
            vertical-align: middle;
            line-height: normal;
            margin-top: 0;
            padding-right: 1.5rem;
            /* keep space for arrow */
            color: #212529;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        /* Arrow container — use SVG background and center vertically */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            width: 1rem;
            height: 1rem;
            display: block;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100% 100%;
            pointer-events: none;
            /* don't block clicks on select */
            /* small SVG caret similar to bootstrap */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 10 6'%3E%3Cpath fill='%23495057' d='M0 0l5 6 5-6z'/%3E%3C/svg%3E");
        }

        /* Hide the default <b> triangle element used by Select2 so it doesn't conflict with the SVG */
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            display: none;
        }

        /* When control is focused, match bootstrap outline */
        .select2-container--default .select2-selection--single:focus,
        .select2-container--default .select2-selection--single:active,
        .select2-container--default .select2-selection--single.select2-container--focus {
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-color: #86b7fe;
        }

        /* Validation states */
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default .select2-selection--single.is-invalid {
            border-color: #dc3545;
        }

        .select2-container--default .select2-selection--single.is-invalid {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.1);
        }

        /* Make sure Select2's arrow doesn't overlap text */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            width: calc(100% - 2.5rem);
        }

        /* Small responsiveness fix for small screens */
        @media (max-width: 576px) {
            .select2-container--default .select2-selection--single {
                padding: 0.35rem 0.6rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // unit_lainnya removed; no toggle function needed

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2 on Unit and Dosen selects with Bootstrap-5-like styling
            $('#unit_id').select2({
                width: '100%',
                placeholder: 'Pilih Unit',
                allowClear: true,
                dropdownParent: $('#unit_id').closest('.card-body')
            });

            $('#id_dosen').select2({
                width: '100%',
                placeholder: 'Pilih Dosen',
                allowClear: true,
                dropdownParent: $('#id_dosen').closest('.card-body')
            });

            // If server-side validation marked the original select invalid, reflect that on Select2 UI
            if ($('#unit_id').hasClass('is-invalid')) {
                // target the specific select2 container next to the original select
                $('#unit_id').next('.select2-container').find('.select2-selection--single').addClass('is-invalid');
            }
            if ($('#id_dosen').hasClass('is-invalid')) {
                $('#id_dosen').next('.select2-container').find('.select2-selection--single').addClass('is-invalid');
            }

            // Re-select old/current values (helps when validation fails and old() exists)
            var oldUnit = "{{ old('unit_id', $magang->unit_id) }}";
            if (oldUnit) {
                $('#unit_id').val(oldUnit).trigger('change');
            }

            var oldDosen = "{{ old('id_dosen', $magang->id_dosen) }}";
            if (oldDosen) {
                $('#id_dosen').val(oldDosen).trigger('change');
            }

            // When Select2 value changes, call toggle function for unit
            $('#unit_id').on('change', function() {
                toggleUnitLainnya($(this).val());
            });

            // Trigger initial toggle in case select2 changed the DOM or value
            toggleUnitLainnya($('#unit_id').val());
        });
    </script>
@endpush
