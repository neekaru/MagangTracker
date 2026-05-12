# Hasil Pengujian Blackbox

| No | Modul/Halaman | URL | Skenario Pengujian | Input/Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|---|
| 1 | Login | `/login` | Halaman login ditampilkan | Buka halaman login | Form login tampil normal | Halaman login tampil | Berhasil |
| 2 | Login Admin | `/login` | Login dengan akun admin valid | `admin@magang.com` / `password123` | Sistem menerima login dan mengarahkan ke dashboard admin | Login berhasil dan masuk ke `/admin` | Berhasil |
| 3 | Login Pembimbing | `/login` | Login dengan akun pembimbing valid | `dosen@magang.com` / `password123` | Sistem menerima login dan mengarahkan ke dashboard pembimbing | Login berhasil dan masuk ke `/pembimbing` | Berhasil |
| 4 | Login Mahasiswa | `/login` | Login dengan akun mahasiswa valid | `mahasiswa@magang.com` / `password123` | Sistem menerima login dan mengarahkan ke dashboard mahasiswa | Login berhasil dan masuk ke `/mahasiswa` | Berhasil |
| 5 | Login Gagal | `/login` | Login dengan password salah | `admin@magang.com` / `salah123` | Sistem menolak login dan menampilkan pesan error | Muncul pesan `Email atau password salah.` | Berhasil |
| 6 | Dashboard Admin | `/admin` | Menampilkan dashboard admin | Login sebagai admin | Dashboard dan ringkasan data tampil | Tampil data `Peserta Aktif`, `Pembimbing`, `Pendaftaran Baru`, `Logbook Hari Ini`, statistik periode, aktivitas terbaru | Berhasil |
| 7 | Menu Admin | `/admin` | Menampilkan menu admin | Login sebagai admin | Semua menu admin tampil sesuai hak akses | Tampil menu `Dashboard`, `Users`, `Data Magang`, `Periode`, `Unit Bisnis`, `Jurnal Kegiatan`, `Absensi`, `Laporan` | Berhasil |
| 8 | Data Peserta Magang | `/admin/magang` | Menampilkan halaman data peserta magang | Login sebagai admin | Halaman dan tabel data tampil | Halaman tampil dan data tampil | Berhasil |
| 9 | Tambah Data Magang | `/admin/magang/create` | Menambah data peserta magang | Input data valid | Data baru tersimpan | Create berhasil | Berhasil |
| 10 | Edit Data Magang | `/admin/magang/{id}/edit` | Mengubah data peserta magang | Ubah data valid | Perubahan data tersimpan | Edit berhasil | Berhasil |
| 11 | Hapus Data Magang | `/admin/magang` | Menghapus data peserta magang | Pilih data dan hapus | Data terhapus dari sistem | Hapus berhasil | Berhasil |
| 12 | Laporan Admin | `/admin/laporan` | Menampilkan halaman laporan | Login sebagai admin | Halaman laporan dan filter tampil | Halaman laporan tampil | Berhasil |
| 13 | Filter Laporan Admin | `/admin/laporan` | Menjalankan filter laporan | Filter periode/status/unit | Data laporan difilter sesuai input | Filter berhasil | Berhasil |
| 14 | Export PDF Admin | `/admin/laporan/export-pdf` | Mengunduh laporan PDF | Klik export PDF | File PDF berhasil dibuat/diunduh | Export PDF berhasil | Berhasil |
| 15 | Export Excel Admin | `/admin/laporan/export-excel` | Mengunduh laporan Excel | Klik export Excel | File Excel berhasil dibuat/diunduh | Export Excel berhasil | Berhasil |
| 16 | Dashboard Mahasiswa | `/mahasiswa` | Menampilkan dashboard mahasiswa | Login sebagai mahasiswa | Dashboard mahasiswa tampil | Dashboard tampil dan ringkasan aktivitas muncul | Berhasil |
| 17 | Logbook Mahasiswa | `/mahasiswa/logbook` | Menampilkan halaman logbook | Login sebagai mahasiswa | Halaman logbook dan data tampil | Halaman logbook tampil | Berhasil |
| 18 | Tambah Logbook | `/mahasiswa/logbook/create` | Menambah logbook baru | Input logbook valid | Data logbook tersimpan | Tambah logbook berhasil | Berhasil |
| 19 | Absensi Mahasiswa | `/mahasiswa/absensi` | Menampilkan halaman absensi | Login sebagai mahasiswa | Halaman absensi dan riwayat tampil | Halaman absensi tampil | Berhasil |
| 20 | Tambah Absensi | `/mahasiswa/absensi/create` | Menambah absensi mahasiswa | Input absensi valid | Data absensi tersimpan | Tambah absensi berhasil | Berhasil |
| 21 | Dashboard Pembimbing | `/pembimbing` | Menampilkan dashboard pembimbing | Login sebagai pembimbing | Dashboard dan ringkasan data tampil | Tampil `Peserta Bimbingan`, `Jurnal Kegiatan Pending`, `Absensi Hari Ini`, `Daftar Peserta Bimbingan` | Berhasil |
| 22 | Peserta Bimbingan | `/pembimbing/peserta` | Menampilkan daftar peserta bimbingan | Login sebagai pembimbing | Data peserta tampil | Data peserta tampil | Berhasil |
| 23 | Detail Peserta Bimbingan | `/pembimbing/peserta/{id}` | Membuka detail peserta | Klik detail peserta | Detail peserta dapat dibuka | Detail berhasil dibuka | Berhasil |
| 24 | Logbook Pembimbing | `/pembimbing/logbook` | Menampilkan daftar logbook mahasiswa | Login sebagai pembimbing | Data logbook tampil | Data logbook tampil | Berhasil |
| 25 | Detail Logbook Pembimbing | `/pembimbing/logbook/{id}` | Membuka detail logbook | Klik detail logbook | Detail logbook dapat dibuka | Detail berhasil dibuka | Berhasil |
| 26 | Validasi Logbook | `/pembimbing/logbook/{id}` | Memvalidasi logbook mahasiswa | Ubah status validasi | Status logbook berhasil diperbarui | Validasi berhasil | Berhasil |
| 27 | Absensi Pembimbing | `/pembimbing/absensi` | Menampilkan data absensi mahasiswa | Login sebagai pembimbing | Data absensi tampil | Data absensi tampil | Berhasil |
| 28 | Validasi Absensi Pembimbing | `/pembimbing/absensi/{id}` | Update/validasi absensi mahasiswa | Ubah status absensi | Status absensi berhasil diperbarui | Validasi berhasil | Berhasil |
| 29 | Laporan Pembimbing | `/pembimbing/laporan` | Menampilkan halaman laporan pembimbing | Login sebagai pembimbing | Halaman laporan tampil | Halaman laporan tampil | Berhasil |
| 30 | Export PDF Pembimbing | `/pembimbing/laporan/export-pdf` | Mengunduh laporan PDF | Klik export PDF | PDF berhasil diunduh | Export PDF berhasil | Berhasil |
| 31 | Export Excel Pembimbing | `/pembimbing/laporan/export-excel` | Mengunduh laporan Excel | Klik export Excel | Excel berhasil diunduh | Export Excel berhasil | Berhasil |
| 32 | Profil Mahasiswa | `/mahasiswa/profil` | Menampilkan halaman profil | Login sebagai mahasiswa | Halaman profil tampil | Halaman profil tampil | Berhasil |
| 33 | Edit Profil Mahasiswa | `/mahasiswa/profil` | Mengubah data profil | Ubah data profil valid | Perubahan profil tersimpan | Edit profil berhasil | Berhasil |
| 34 | Status Magang Mahasiswa | `/mahasiswa/magang` | Menampilkan status/data magang | Login sebagai mahasiswa | Data status magang tampil | Halaman status magang tampil dan data muncul | Berhasil |
