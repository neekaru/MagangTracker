<div class="mb-3">
    <label for="magang_id" class="form-label">Peserta Magang</label>
    <select class="form-select" id="magang_id" name="magang_id" required>
        <option value="">-- Pilih Peserta --</option>
        @foreach($magangs as $magang)
            <option value="{{ $magang->id }}" @selected(old('magang_id', optional($absensi)->magang_id) == $magang->id)>
                {{ $magang->mahasiswa->nama_lengkap ?? 'Mahasiswa' }} - {{ $magang->unitBisnis->nama_unit_bisnis ?? 'Unit' }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="jenis_absen" class="form-label">Jenis Absensi</label>
    <select class="form-select" id="jenis_absen" name="jenis_absen" required>
        <option value="">-- Pilih Jenis Absensi --</option>
        <option value="masuk" @selected(old('jenis_absen', optional($absensi)->jenis_absen) == 'masuk')>Masuk</option>
        <option value="pulang" @selected(old('jenis_absen', optional($absensi)->jenis_absen) == 'pulang')>Pulang</option>
    </select>
</div>
<div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', isset($absensi) ? \Carbon\Carbon::parse($absensi->tanggal)->format('Y-m-d') : date('Y-m-d')) }}" required>
</div>
<div class="mb-3">
    <label for="jam" class="form-label">Jam</label>
    <input type="time" class="form-control" id="jam" name="jam" value="{{ old('jam', optional($absensi)->jam ?? date('H:i')) }}">
</div>
<div class="mb-3">
    <label for="status_kehadiran" class="form-label">Status Kehadiran</label>
    <select class="form-select" id="status_kehadiran" name="status_kehadiran" required>
        <option value="Hadir" @selected(old('status_kehadiran', optional($absensi)->status_kehadiran) == 'Hadir')>Hadir</option>
        <option value="Izin" @selected(old('status_kehadiran', optional($absensi)->status_kehadiran) == 'Izin')>Izin</option>
        <option value="Sakit" @selected(old('status_kehadiran', optional($absensi)->status_kehadiran) == 'Sakit')>Sakit</option>
    </select>
</div>
<div class="mb-3">
    <label for="status_validasi" class="form-label">Status Validasi</label>
    <select class="form-select" id="status_validasi" name="status_validasi" required>
        <option value="pending" @selected(old('status_validasi', optional($absensi)->status_validasi ?? 'pending') == 'pending')>Menunggu</option>
        <option value="approved" @selected(old('status_validasi', optional($absensi)->status_validasi) == 'approved')>Disetujui</option>
        <option value="rejected" @selected(old('status_validasi', optional($absensi)->status_validasi) == 'rejected')>Ditolak</option>
    </select>
</div>
<div class="mb-3">
    <label for="keterangan" class="form-label">Keterangan</label>
    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan catatan jika perlu...">{{ old('keterangan', optional($absensi)->keterangan) }}</textarea>
</div>
