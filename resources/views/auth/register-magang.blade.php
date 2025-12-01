<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Magang - MagangTracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Formulir Pendaftaran Magang</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('/register-magang') }}" method="POST">
                        @csrf
                        <h5 class="mb-3">Data Pribadi</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nim" class="form-label">NIM / NISN</label>
                                <input type="text" class="form-control" id="nim" name="nim" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="asal_sekolah" class="form-label">Asal Sekolah / Kampus</label>
                            <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" required>
                        </div>

                        <h5 class="mb-3 mt-4">Rencana Magang</h5>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit Tujuan</label>
                            <select class="form-select" id="unit" name="unit" required>
                                <option value="">Pilih Unit...</option>
                                <option value="IT">IT Support</option>
                                <option value="Keuangan">Keuangan</option>
                                <option value="HRD">HRD</option>
                                <option value="Umum">Bagian Umum</option>
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Pendaftaran</button>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
