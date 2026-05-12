# MagangTracking

MagangTracking adalah sistem administrasi akademik magang berbasis web.

## Aktor Sistem

Sistem dibatasi pada 3 peran utama:

- Admin
- Pembimbing
- Mahasiswa

## Ruang Lingkup

Fitur difokuskan pada administrasi kegiatan magang:

- Pengelolaan data peserta magang
- Pencatatan aktivitas harian (logbook)
- Rekapitulasi absensi kehadiran

Di luar lingkup sistem ini:

- Integrasi dengan SIA kampus
- KRS
- Pembayaran kuliah (UKT/SPP)

## Platform dan Antarmuka

- Aplikasi berbasis web
- Antarmuka utama desktop dengan dukungan responsif dasar untuk mobile
- Akses menu dan data disesuaikan berdasarkan peran pengguna

## Ketentuan Absensi

- Absensi diisi mandiri oleh mahasiswa melalui web
- Waktu absensi dicatat menggunakan waktu server
- Lokasi GPS (latitude, longitude) disimpan sebagai informasi pendukung
- Tidak ada validasi radius lokasi
- Keabsahan absensi mengikuti approval logbook oleh pembimbing

## Laporan

Admin dan Pembimbing dapat mengunduh laporan dalam format:

- PDF
- Excel

Laporan mencakup rekap kegiatan harian dan absensi.
