# Frontend Plan – Sistem Manajemen Data Karyawan Magang Berbasis Web

Sistem: Manajemen data karyawan/peserta magang berbasis web di Politeknik Sampit dengan 3 peran utama: **Admin**, **Pembimbing**, dan **Mahasiswa**. Fokus pada **desktop interface** (responsive secukupnya untuk tablet/HP) dan fitur: pendaftaran, logbook harian, absensi, penilaian, serta laporan (PDF/Excel). :contentReference[oaicite:0]{index=0}  

---

## 1. Tujuan Frontend

- Menyediakan UI yang jelas dan mudah diakses sesuai peran pengguna.
- Mengintegrasikan proses:
  - Pendaftaran magang.
  - Pencatatan logbook harian & absensi.
  - Monitoring & penilaian kinerja peserta magang.
  - Pembuatan & unduh laporan (PDF/Excel).
- Meminimalkan penggunaan berkas fisik (paperless) dan redundansi data.

---

## 2. Peran Pengguna & Hak Akses

1. **Admin**
   - Kelola data user (Admin, Pembimbing, Mahasiswa).
   - Kelola data magang (pendaftaran, penempatan, periode).
   - Melihat dan mengelola logbook & absensi.
   - Mengelola konfigurasi penilaian.
   - Menghasilkan & mengunduh laporan.

2. **Pembimbing** (Dosen Pembimbing & Pembimbing Lapangan)
   - Melihat daftar peserta magang bimbingan.
   - Memantau logbook & absensi peserta.
   - Menginput penilaian kinerja & nilai akhir magang.
   - Mengunduh laporan peserta yang dibimbing.

3. **Mahasiswa / Peserta Magang**
   - Mengajukan pendaftaran magang.
   - Mengisi logbook harian.
   - Mengisi absensi mandiri (berdasarkan waktu & lokasi input, tanpa GPS tracking).
   - Melihat rekap kegiatan, absensi, dan nilai akhir.

---

## 3. Struktur Global Frontend

- **Framework (opsional, bisa disesuaikan)**: React / Vue / Next / Laravel Blade; rute di bawah dibuat generik dengan gaya `/path`.
- **Layout umum:**
  - Header (nama sistem, role aktif, tombol logout).
  - Sidebar navigasi (menu berbeda per role).
  - Content area (untuk render halaman sesuai route).
  - Footer (informasi instansi, versi sistem).

- **Komponen Reusable:**
  - `AuthForm`, `TextInput`, `SelectInput`, `DatePicker`, `Table`, `Pagination`, `Modal`, `ConfirmDialog`.
  - `ExportButton` (PDF/Excel).
  - `RoleBadge` (Admin/Pembimbing/Mahasiswa).
  - `StatusBadge` (pending, disetujui, selesai).

---

## 4. Struktur Route Frontend

> Catatan: gunakan prefix `/admin`, `/pembimbing`, `/mahasiswa` untuk memisahkan dashboard berdasarkan role.  

### 4.1. Public Routes (Tanpa Login)

1. `GET /`
   - Landing page singkat sistem.
   - Informasi singkat: apa itu sistem, link login, link panduan singkat.

2. `GET /login`
   - Form login (email/username + password, pilih/auto detect role).
   - Tombol: `Masuk`, link ke lupa password.

3. `GET /forgot-password`
   - Form input email untuk reset password (atau instruksi manual, sesuai backend).

4. `GET /register-magang` (opsional, jika pendaftaran dibuka umum)
   - Form pengajuan pendaftaran magang:
     - Data pribadi;
     - Program studi;
     - Lokasi/Unit tujuan magang;
     - Periode magang.
   - Status awal: pending – diverifikasi admin.

---

### 4.2. Route Dasar per Role (Dashboard)

#### 4.2.1. Admin

##### Root
- `GET /admin`
  - Dashboard ringkasan:
    - Jumlah peserta magang aktif.
    - Jumlah pembimbing.
    - Kartu ringkas: pendaftaran baru, logbook hari ini, absensi hari ini.
    - Grafik sederhana (opsional): jumlah magang per periode/unit.

##### Manajemen Pengguna
1. `GET /admin/users`
   - Tabel daftar pengguna (Admin, Pembimbing, Mahasiswa).
   - Fitur:
     - Filter per role.
     - Search.
     - Pagination.
   - Aksi:
     - Tambah user.
     - Edit.
     - Nonaktifkan/aktifkan.

2. `GET /admin/users/create`
   - Form tambah user:
     - Nama lengkap
     - Email/username
     - Role (Admin/Pembimbing/Mahasiswa)
     - Password awal

3. `GET /admin/users/:id/edit`
   - Form edit data user.

4. `GET /admin/users/:id`
   - Halaman detail user (opsional):
     - Profil singkat.
     - Riwayat magang (untuk mahasiswa).
     - Daftar peserta bimbingan (untuk pembimbing).

##### Manajemen Pendaftaran & Data Magang
1. `GET /admin/magang`
   - List pendaftaran & peserta magang:
     - Tab: `Pendaftaran Baru`, `Aktif`, `Selesai`.
   - Kolom tabel:
     - Nama peserta, NIM, program studi, unit magang, periode, status.
   - Aksi:
     - Review pendaftaran.
     - Ubah status (pending → disetujui/ditolak).
     - Hapus (jika diperlukan).

2. `GET /admin/magang/:id`
   - Detail satu peserta magang:
     - Data pribadi.
     - Data magang (unit, pembimbing, periode).
     - Ringkasan logbook & absensi.
     - Status & nilai akhir.

3. `GET /admin/magang/create` (opsional)
   - Input manual data magang (untuk peserta yang tidak daftar via sistem).

4. `GET /admin/periode-magang`
   - Manajemen periode magang:
     - Tambah periode (tanggal mulai, akhir, tahun akademik/semester).
     - Set status periode (aktif/nonaktif).

##### Logbook & Absensi (Admin View)
1. `GET /admin/logbook`
   - Tabel logbook semua peserta:
     - Filter: periode, unit, pembimbing, peserta, tanggal.
   - View-only, dengan opsi koreksi/validasi jika dibutuhkan.

2. `GET /admin/logbook/:id` / `GET /admin/magang/:magangId/logbook`
   - Detail logbook satu peserta:
     - List harian (tanggal, deskripsi kegiatan, jam mulai–akhir, status verifikasi pembimbing).

3. `GET /admin/absensi`
   - Rekap absensi semua peserta:
     - Kolom: peserta, tanggal, jam, keterangan (hadir/izin/sakit), lokasi input (jika ada).
   - Filter & export.

4. `GET /admin/magang/:magangId/absensi`
   - Rekap absensi 1 peserta.

##### Penilaian & Laporan
1. `GET /admin/penilaian`
   - List peserta dengan status penilaian:
     - Belum dinilai, proses, selesai.
   - Aksi:
     - Buka detail penilaian.

2. `GET /admin/penilaian/:magangId`
   - Detail penilaian peserta:
     - Nilai dari pembimbing lapangan.
     - Nilai dari dosen pembimbing.
     - Komponen penilaian (disiplin, kehadiran, kemampuan teknis, dll).
     - Nilai akhir dan status lulus/tidak.

3. `GET /admin/laporan`
   - Halaman generate laporan:
     - Filter: periode, unit, pembimbing, status magang.
     - Pilihan format: PDF/Excel.
     - Tombol: `Export`.

4. `GET /admin/laporan/magang/:magangId`
   - Preview laporan individual (resume logbook, absensi, nilai akhir).
   - Tombol unduh PDF.

---

#### 4.2.2. Pembimbing

##### Root
- `GET /pembimbing`
  - Dashboard ringkasan:
    - Jumlah peserta bimbingan aktif.
    - Logbook terbaru dari peserta.
    - Absensi hari ini.
    - Shortcut ke halaman penilaian.

##### Daftar Peserta Bimbingan
1. `GET /pembimbing/peserta`
   - List peserta magang yang dibimbing:
     - Kolom: nama, NIM, program studi, unit, periode, status.
   - Aksi:
     - Lihat logbook.
     - Lihat absensi.
     - Buka penilaian.

2. `GET /pembimbing/peserta/:magangId`
   - Detail peserta (view seperti admin tapi terbatas):
     - Data diri.
     - Periode & unit.
     - Ringkasan logbook & absensi.
     - Status penilaian.

##### Logbook & Absensi (Pembimbing View)
1. `GET /pembimbing/peserta/:magangId/logbook`
   - List logbook harian:
     - Status: menunggu verifikasi / disetujui / ditolak.
   - Aksi:
     - Verifikasi (approve/reject).
     - Beri komentar singkat (opsional).

2. `GET /pembimbing/peserta/:magangId/absensi`
   - Rekap absensi peserta.
   - Aksi:
     - Koreksi/konfirmasi (opsional, tergantung aturan).

##### Penilaian & Laporan
1. `GET /pembimbing/penilaian`
   - List peserta yang perlu dinilai.

2. `GET /pembimbing/penilaian/:magangId`
   - Form penilaian:
     - Input skor tiap komponen.
     - Catatan pembimbing.
     - Simpan & finalisasi nilai.

3. `GET /pembimbing/laporan`
   - Fitur unduh laporan per peserta atau per bimbingan:
     - Filter: periode, peserta.
     - Export PDF / Excel.

---

#### 4.2.3. Mahasiswa / Peserta Magang

##### Root
- `GET /mahasiswa`
  - Dashboard sederhana:
    - Status pendaftaran magang.
    - Ringkasan kehadiran (persentase).
    - Ringkasan logbook minggu ini.
    - Jika sudah dinilai: ringkasan nilai akhir.

##### Profil & Data Magang
1. `GET /mahasiswa/profil`
   - View & edit profil (nama, kontak, password).
2. `GET /mahasiswa/magang`
   - Ringkasan info magang:
     - Unit penempatan.
     - Pembimbing.
     - Periode.
     - Status (aktif/selesai/pending).

##### Pendaftaran Magang
1. `GET /mahasiswa/pendaftaran-magang`
   - Form pendaftaran:
     - Data diri (auto dari profil jika sudah).
     - Lokasi/Unit tujuan.
     - Periode.
     - Upload berkas pendukung (jika ada).
   - Tampilkan status pendaftaran.

##### Logbook Harian (Mahasiswa)
1. `GET /mahasiswa/logbook`
   - List logbook harian:
     - Kolom: tanggal, deskripsi kegiatan, jam, status verifikasi pembimbing.
   - Tombol: `Tambah logbook`.

2. `GET /mahasiswa/logbook/create`
   - Form tambah logbook:
     - Tanggal (default hari ini).
     - Deskripsi kegiatan.
     - Jam mulai & selesai.
     - Output/keterangan.

3. `GET /mahasiswa/logbook/:id/edit`
   - Edit logbook sebelum diverifikasi.

##### Absensi Mandiri
1. `GET /mahasiswa/absensi`
   - Rekap absensi:
     - Tabel: tanggal, jam, status (hadir, izin, sakit), keterangan.

2. `GET /mahasiswa/absensi/create`
   - Form isi absensi:
     - Tanggal & jam (otomatis dari server, non-editable atau dibatasi).
     - Status (hadir, izin, sakit).
     - Keterangan.
     - (Opsi) Input lokasi (manual -> text, tanpa GPS tracking).

##### Penilaian & Laporan
1. `GET /mahasiswa/nilai`
   - Tampilkan nilai akhir magang.
   - Komponen per aspek (disiplin, kehadiran, dll).
   - Komentar pembimbing.

2. `GET /mahasiswa/laporan`
   - Unduh laporan pribadi:
     - Rekap logbook.
     - Rekap absensi.
     - Nilai akhir magang.

---

## 5. Routing Error & Utility Pages

1. `GET /403`
   - Akses ditolak (role tidak sesuai).

2. `GET /404`
   - Halaman tidak ditemukan.

3. `GET /500`
   - Error server (fallback).

---

## 6. Struktur Navigasi Singkat (Ringkasan)

### Public
- `/`
- `/login`
- `/forgot-password`
- `/register-magang` (opsional)

### Admin
- `/admin`
- `/admin/users`
- `/admin/users/create`
- `/admin/users/:id/edit`
- `/admin/users/:id`
- `/admin/magang`
- `/admin/magang/create`
- `/admin/magang/:id`
- `/admin/periode-magang`
- `/admin/logbook`
- `/admin/magang/:magangId/logbook`
- `/admin/absensi`
- `/admin/magang/:magangId/absensi`
- `/admin/penilaian`
- `/admin/penilaian/:magangId`
- `/admin/laporan`
- `/admin/laporan/magang/:magangId`

### Pembimbing
- `/pembimbing`
- `/pembimbing/peserta`
- `/pembimbing/peserta/:magangId`
- `/pembimbing/peserta/:magangId/logbook`
- `/pembimbing/peserta/:magangId/absensi`
- `/pembimbing/penilaian`
- `/pembimbing/penilaian/:magangId`
- `/pembimbing/laporan`

### Mahasiswa
- `/mahasiswa`
- `/mahasiswa/profil`
- `/mahasiswa/magang`
- `/mahasiswa/pendaftaran-magang`
- `/mahasiswa/logbook`
- `/mahasiswa/logbook/create`
- `/mahasiswa/logbook/:id/edit`
- `/mahasiswa/absensi`
- `/mahasiswa/absensi/create`
- `/mahasiswa/nilai`
- `/mahasiswa/laporan`

---

## 7. Catatan Implementasi

- **Desktop-first** sesuai batasan masalah, tetap buat layout responsive minimal.
- Validasi input sisi frontend (required fields, format tanggal, dll).
- Setiap route yang perlu otorisasi wajib dicek role-nya (guard).
- Fitur export PDF/Excel cukup berupa tombol yang memanggil endpoint backend, frontend hanya menampilkan tombol dan status loading.

