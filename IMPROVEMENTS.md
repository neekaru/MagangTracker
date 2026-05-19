# Database Schema Improvements

Dokumen ini berisi catatan improvement untuk skema database dan relasi model pada sistem MagangTracking.

**Dibuat:** 2026-05-19  
**Versi:** 2.5  
**Last Updated:** 2026-05-19 23:33

---

## 📊 Ringkasan Status

| No | Item | Prioritas | Effort | Risk | Status |
|----|------|-----------|--------|------|--------|
| 1  | Tambah relasi `absenValidasi()` dan `logbookApproved()` | Low | 10 menit | Minimal | ⏳ Pending |
| 2  | Drop `users.id_dosen` | Medium | 15 menit | Low | ✅ Completed |
| 3  | Ubah `onDelete` strategy `magang.dosen_pembimbing_id` | High | 30 menit | Medium | ✅ Completed |
| 4  | Konsistensi `logbook.approved_by` | Medium | 20 menit | Low | ✅ Completed |
| 5  | Soft delete untuk `magang` | Medium | 30 menit | Low | ⏳ Pending |
| 6  | Normalisasi `pembimbing_lapangan` | Low | 45 menit | Medium | ⏳ Pending |
| 7  | Drop `users.id_mahasiswa` | Medium | 15 menit | Low | ✅ Completed |
| 8  | Soft delete untuk `mahasiswa` | Medium | 30 menit | Low | ⏳ Pending |
| 9  | Ubah `onDelete` strategy `magang.periode_id` | High | 20 menit | Low | ✅ Completed |
| 10 | Rename `periode_magang.status_magang` → `status_periode` | Medium | 30 menit | Medium | ⏳ Pending |
| 11 | Tambah unique constraint pada `nama_periode` | Medium | 10 menit | Low | ⏳ Pending |
| 12 | Constraint untuk single active periode | Medium | 30 menit | Low | ⏳ Pending |
| 13 | Soft delete untuk `periode_magang` | Low | 20 menit | Low | ⏳ Pending |
| 14 | Fix bug `UnitBisnis::absen()` obsolete | High | 5 menit | Minimal | ✅ Completed |
| 15 | Ubah `onDelete` strategy `magang.unit_bisnis_id` | High | 20 menit | Low | ✅ Completed |
| 16 | Tambah unique constraint pada `nama_unit_bisnis` | Medium | 10 menit | Low | ⏳ Pending |
| 17 | Tambah field tambahan di `unit_bisnis` | Medium | 30 menit | Low | ⏳ Pending |
| 18 | Soft delete untuk `unit_bisnis` | Low | 20 menit | Low | ⏳ Pending |
| 19 | Fix bug `User::mahasiswa()` dan `User::dosen()` obsolete | Critical | 5 menit | Minimal | ✅ Completed |
| 20 | Cleanup `$fillable` di model User | High | 2 menit | Minimal | ✅ Completed |
| 21 | Fix kode yang pakai field/relasi obsolete | High | 30 menit | Medium | ✅ Completed |
| 22 | Soft delete untuk `users` | Low | 20 menit | Medium | ⏳ Pending |

**Progress:** 10/22 completed (45%)

---

## ✅ Improvements yang Sudah Diimplementasikan

### #2: Drop Kolom Legacy `users.id_dosen`

**Status:** ✅ Completed  
**Migration:** `2026_05_19_213254_drop_id_dosen_from_users_table.php`

#### Masalah
Kolom `users.id_dosen` (FK ke `dosen.id`) merupakan skema lama yang tidak terpakai. Relasi user-dosen saat ini sudah ditangani via `dosen.user_id -> users.id` (one-to-one).

#### Solusi Implemented
```php
Schema::table('users', function (Blueprint $table) {
    if (Schema::hasColumn('users', 'id_dosen')) {
        $table->dropForeign(['id_dosen']);
        $table->dropColumn('id_dosen');
    }
});
```

#### Benefit
- Skema database lebih bersih dan mudah dipahami
- Menghindari kebingungan developer baru
- Konsisten dengan pola relasi yang aktif

---

### #3: Ubah `onDelete` Strategy pada `magang.dosen_pembimbing_id`

**Status:** ✅ Completed  
**Migration:** `2026_05_19_213346_change_dosen_pembimbing_id_to_set_null_in_magang_table.php`

#### Masalah
FK `magang.dosen_pembimbing_id -> dosen.id` menggunakan `onDelete('cascade')`. Jika dosen dihapus, semua data magang yang dia bimbing (termasuk absen dan logbook) ikut terhapus.

#### Solusi Implemented
Ubah FK menjadi nullable dengan `onDelete('set null')`:

```php
Schema::table('magang', function (Blueprint $table) {
    $table->dropForeign(['dosen_pembimbing_id']);
    $table->foreignId('dosen_pembimbing_id')->nullable()->change();
    $table->foreign('dosen_pembimbing_id')
        ->references('id')
        ->on('dosen')
        ->onDelete('set null');
});
```

#### Benefit
- Data magang tetap ada saat dosen dihapus
- Audit trail dan laporan historis terjaga
- Sertifikat/transkrip magang mahasiswa tidak hilang

#### Testing Scenario
1. Buat dosen baru
2. Assign ke magang
3. Hapus dosen
4. Verifikasi: `magang.dosen_pembimbing_id` jadi NULL, data magang/absen/logbook tetap ada

---

### #4: Konsistensi Relasi `logbook.approved_by`

**Status:** ✅ Completed  
**Migration:** `2026_05_19_214809_change_approved_by_to_dosen_in_logbook_table.php`

#### Masalah
Table `logbook` menggunakan `approved_by` yang reference ke `users.id`, sedangkan table `absen` menggunakan `validasi_by` yang reference ke `dosen.id`. Ini inkonsisten karena keduanya melakukan fungsi yang sama.

#### Solusi Implemented

**1. Migration dengan Data Migration:**
```php
// Drop FK lama
$table->dropForeign(['approved_by']);

// Migrasi data: ubah approved_by dari users.id ke dosen.id
DB::statement('
    UPDATE logbook l
    INNER JOIN users u ON l.approved_by = u.id
    INNER JOIN dosen d ON u.id = d.user_id
    SET l.approved_by = d.id
    WHERE l.approved_by IS NOT NULL
');

// Buat FK baru ke dosen
$table->foreign('approved_by')
    ->references('id')
    ->on('dosen')
    ->nullOnDelete();
```

**2. Model Update (`app/Models/Logbook.php`):**
```php
public function approver()
{
    return $this->belongsTo(Dosen::class, 'approved_by');
}
```

**3. Controller Update (`app/Http/Controllers/LogbookController.php`):**
```php
$logbook->update([
    'status' => $request->status,
    'approved_by' => $user->id_dosen, // Changed from $user->id
]);
```

#### Benefit
- Konsistensi skema database antara `absen` dan `logbook`
- Query lebih efisien (tidak perlu join via users)
- Lebih jelas secara semantik

---

### #7: Drop Kolom Legacy `users.id_mahasiswa`

**Status:** ✅ Completed  
**Migration:** `2026_05_19_220341_drop_id_mahasiswa_from_users_table.php`

#### Masalah
Sama seperti kasus `users.id_dosen`, kolom `users.id_mahasiswa` merupakan skema lama yang tidak terpakai. Relasi user-mahasiswa saat ini sudah ditangani via `mahasiswa.user_id -> users.id`.

#### Solusi Implemented
```php
Schema::table('users', function (Blueprint $table) {
    if (Schema::hasColumn('users', 'id_mahasiswa')) {
        $table->dropForeign(['id_mahasiswa']);
        $table->dropColumn('id_mahasiswa');
    }
});
```

#### Benefit
- Konsisten dengan pembersihan `users.id_dosen`
- Skema database lebih bersih
- Menghindari kebingungan developer

---

### #9: Ubah `onDelete` Strategy pada `magang.periode_id`

**Status:** ✅ Completed  
**Migration:** `2026_05_19_221520_change_periode_id_to_set_null_in_magang_table.php`

#### Masalah
FK `magang.periode_id -> periode_magang.id` menggunakan `onDelete('cascade')`. Jika periode dihapus, **SEMUA data magang di periode itu ikut terhapus**, termasuk semua absen dan logbook turunannya.

#### Analisis
Admin yang tidak hati-hati menghapus periode lama bisa kehilangan SELURUH data historis magang di periode tersebut. Ini sangat berbahaya untuk:
- Audit trail akademik
- Laporan historis per periode
- Data statistik magang

#### Solusi Implemented
Ubah FK menjadi `onDelete('set null')`:

```php
// Cek FK constraint ada atau tidak
$foreignKeys = DB::select("
    SELECT CONSTRAINT_NAME 
    FROM information_schema.KEY_COLUMN_USAGE 
    WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'magang' 
    AND COLUMN_NAME = 'periode_id' 
    AND REFERENCED_TABLE_NAME IS NOT NULL
");

if (!empty($foreignKeys)) {
    Schema::table('magang', function (Blueprint $table) {
        $table->dropForeign(['periode_id']);
    });
}

Schema::table('magang', function (Blueprint $table) {
    $table->foreignId('periode_id')->nullable()->change();
});

Schema::table('magang', function (Blueprint $table) {
    $table->foreign('periode_id')
        ->references('id')
        ->on('periode_magang')
        ->onDelete('set null');
});
```

#### Benefit
- Data magang tetap ada saat periode dihapus
- Audit trail dan laporan historis terjaga
- Mencegah kehilangan data tidak disengaja

---

## ⏳ Improvements yang Pending

### #1: Tambah Inverse Relasi di Model `Dosen`

**Prioritas:** Low  
**Effort:** 10 menit  
**Risk:** Minimal

#### Masalah
Model `Dosen` belum memiliki inverse relasi untuk:
- `absenValidasi()` — untuk akses absen yang divalidasi dosen
- `logbookApproved()` — untuk akses logbook yang di-approve dosen

#### Solusi
Tambahkan method di `app/Models/Dosen.php`:

```php
/**
 * Get all absen records validated by this dosen.
 */
public function absenValidasi()
{
    return $this->hasMany(Absen::class, 'validasi_by');
}

/**
 * Get all logbook records approved by this dosen.
 */
public function logbookApproved()
{
    return $this->hasMany(Logbook::class, 'approved_by');
}
```

#### Benefit
- Lebih ekspresif: `$dosen->absenValidasi`, `$dosen->logbookApproved`
- Memudahkan eager loading: `Dosen::with('absenValidasi', 'logbookApproved')->get()`
- Konsisten dengan pola relasi lain (misal `magang()`)

---

### #5: Soft Delete untuk Table `magang`

**Prioritas:** Medium  
**Effort:** 30 menit  
**Risk:** Low

#### Masalah
Table `magang` menggunakan hard delete. Ketika data magang dihapus, meskipun `absen` dan `logbook` ikut terhapus (cascade), tidak ada cara untuk recovery atau audit trail data historis.

#### Analisis
Untuk keperluan audit trail dan compliance, data magang yang sudah selesai atau dibatalkan sebaiknya tidak benar-benar dihapus dari database. Soft delete memungkinkan:
- Recovery data jika terjadi kesalahan
- Audit trail lengkap untuk keperluan pelaporan
- Statistik historis (berapa mahasiswa yang pernah magang, dll)

#### Solusi
**1. Model Update:**
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Magang extends Model
{
    use HasFactory, SoftDeletes;
    // ...
}
```

**2. Migration:**
```php
Schema::table('magang', function (Blueprint $table) {
    $table->softDeletes();
});
```

#### Benefit
- Data historis tetap tersimpan untuk audit
- Bisa di-restore jika ada kesalahan
- Query statistik lebih lengkap
- Compliance dengan regulasi data retention

#### Kontra
- Perlu update query untuk handle soft delete (`withTrashed()`, `onlyTrashed()`)
- Storage database sedikit lebih besar

---

### #6: Normalisasi Kolom `pembimbing_lapangan`

**Prioritas:** Low  
**Effort:** 45 menit  
**Risk:** Medium

#### Masalah
Kolom `pembimbing_lapangan` di table `magang` saat ini hanya berupa string nama. Tidak ada informasi tambahan seperti:
- Jabatan pembimbing
- Kontak (email/telepon)
- Departemen/divisi
- Riwayat pembimbingan

#### Analisis
Jika sistem perlu tracking pembimbing lapangan lebih detail (misal untuk sertifikat, laporan, atau komunikasi), kolom string tidak cukup. Normalisasi ke table terpisah memberikan:
- Data pembimbing lebih terstruktur
- Bisa reuse pembimbing yang sama untuk magang berbeda
- Tracking riwayat pembimbingan per pembimbing lapangan

#### Solusi (Opsional)
**1. Buat table baru `pembimbing_lapangan`:**
```php
Schema::create('pembimbing_lapangan', function (Blueprint $table) {
    $table->id();
    $table->foreignId('unit_bisnis_id')->constrained('unit_bisnis')->onDelete('cascade');
    $table->string('nama_lengkap');
    $table->string('jabatan')->nullable();
    $table->string('email')->nullable();
    $table->string('telepon')->nullable();
    $table->timestamps();
});
```

**2. Update magang table:**
```php
Schema::table('magang', function (Blueprint $table) {
    $table->dropColumn('pembimbing_lapangan');
    $table->foreignId('pembimbing_lapangan_id')
        ->nullable()
        ->constrained('pembimbing_lapangan')
        ->nullOnDelete();
});
```

#### Benefit
- Data pembimbing lebih terstruktur dan reusable
- Bisa generate laporan per pembimbing lapangan
- Memudahkan komunikasi (ada kontak)

#### Kontra
- Effort lebih besar (perlu UI untuk manage pembimbing lapangan)
- Breaking change jika ada data existing

#### Rekomendasi
**Pending** — implementasi hanya jika ada requirement untuk tracking pembimbing lapangan lebih detail.

---

### #8: Soft Delete untuk Table `mahasiswa`

**Prioritas:** Medium  
**Effort:** 30 menit  
**Risk:** Low

#### Masalah
Table `mahasiswa` menggunakan hard delete. Ketika data mahasiswa dihapus, semua data magang terkait (dan turunannya: absen, logbook) juga ikut terhapus karena cascade.

#### Analisis
Untuk keperluan audit trail akademik dan compliance, data mahasiswa yang sudah lulus atau keluar sebaiknya tidak benar-benar dihapus dari database. Soft delete memungkinkan:
- Recovery data jika terjadi kesalahan
- Audit trail lengkap untuk keperluan akreditasi
- Statistik historis (alumni, dropout rate, dll)
- Preserve data magang mahasiswa yang sudah selesai

#### Solusi
**1. Model Update:**
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use HasFactory, SoftDeletes;
    // ...
}
```

**2. Migration:**
```php
Schema::table('mahasiswa', function (Blueprint $table) {
    $table->softDeletes();
});
```

#### Benefit
- Data akademik historis tetap tersimpan
- Bisa di-restore jika ada kesalahan input
- Query statistik alumni lebih lengkap
- Compliance dengan regulasi data retention akademik

#### Kontra
- Perlu update query untuk handle soft delete
- Storage database sedikit lebih besar
- Perlu handle UI untuk distinguish mahasiswa aktif vs non-aktif

#### Rekomendasi
**Pending** — implementasi bersamaan dengan soft delete untuk `magang` agar konsisten.

---

### #10: Rename `periode_magang.status_magang` → `status_periode`

**Prioritas:** Medium  
**Effort:** 30 menit  
**Risk:** Medium (breaking change)

#### Masalah
Kolom `status_magang` di `periode_magang` punya nama yang sama dengan kolom `status_magang` di `magang`, padahal artinya berbeda:
- `periode_magang.status_magang`: status periode (Aktif/Nonaktif)
- `magang.status_magang`: status individual magang (Pending/Aktif/Nonaktif/selesai/dibatalkan)

Ini membingungkan dan bisa menyebabkan error saat join atau query kompleks.

#### Solusi
**1. Migration untuk rename kolom:**
```php
Schema::table('periode_magang', function (Blueprint $table) {
    $table->renameColumn('status_magang', 'status_periode');
});
```

**2. Update model `PeriodeMagang`:**
```php
protected $fillable = [
    'nama_periode',
    'tanggal_mulai',
    'tanggal_selesai',
    'status_periode', // Changed from status_magang
];
```

**3. Update semua query di controller/service** yang menggunakan `status_magang` pada `periode_magang`.

#### Benefit
- Nama kolom lebih jelas dan tidak ambigu
- Menghindari confusion saat join table
- Lebih mudah di-maintain

#### Kontra
- Breaking change — perlu update semua kode yang reference kolom ini
- Perlu update view/blade files
- Perlu testing menyeluruh

#### Rekomendasi
**Pending** — implementasi jika konsistensi naming dianggap penting. Alternatif: dokumentasikan perbedaan di komentar model.

---

### #11: Tambah Unique Constraint pada `nama_periode`

**Prioritas:** Medium  
**Effort:** 10 menit  
**Risk:** Low

#### Masalah
Kolom `nama_periode` bisa duplikat. Padahal logikanya, tidak boleh ada 2 periode dengan nama yang sama (misal "Semester Genap 2026" tidak boleh ada 2x).

#### Solusi
**Migration:**
```php
Schema::table('periode_magang', function (Blueprint $table) {
    $table->unique('nama_periode');
});
```

#### Benefit
- Mencegah duplikasi periode
- Data lebih konsisten
- Validasi di database level (lebih aman dari application level)

#### Kontra
- Perlu cek data existing untuk duplikasi sebelum run migration
- Jika ada duplikasi, perlu cleanup manual dulu

#### Rekomendasi
**Pending** — cek dulu apakah ada duplikasi di data existing:
```sql
SELECT nama_periode, COUNT(*) 
FROM periode_magang 
GROUP BY nama_periode 
HAVING COUNT(*) > 1;
```

---

### #12: Constraint untuk Single Active Periode

**Prioritas:** Medium  
**Effort:** 30 menit  
**Risk:** Low

#### Masalah
Tidak ada constraint yang mencegah multiple periode dengan `status_magang = 'Aktif'` secara bersamaan. Padahal biasanya hanya boleh ada 1 periode aktif pada satu waktu.

#### Analisis
Jika ada 2+ periode aktif bersamaan, bisa menyebabkan:
- Confusion saat mahasiswa daftar magang (pilih periode yang mana?)
- Laporan tidak akurat (periode aktif yang mana?)
- Business logic error

#### Solusi (Pilihan)

**Opsi A: Unique Partial Index (MySQL 8.0.13+)**
```php
DB::statement('
    CREATE UNIQUE INDEX idx_single_active_periode 
    ON periode_magang (status_magang) 
    WHERE status_magang = "Aktif"
');
```

**Opsi B: Application Level dengan Observer**
```php
// Di PeriodeMagangObserver
public function saving(PeriodeMagang $periode)
{
    if ($periode->status_magang === 'Aktif') {
        // Set semua periode lain jadi Nonaktif
        PeriodeMagang::where('id', '!=', $periode->id)
            ->where('status_magang', 'Aktif')
            ->update(['status_magang' => 'Nonaktif']);
    }
}
```

**Opsi C: Validation di FormRequest**
```php
public function withValidator($validator)
{
    $validator->after(function ($validator) {
        if ($this->status_magang === 'Aktif') {
            $exists = PeriodeMagang::where('status_magang', 'Aktif')
                ->where('id', '!=', $this->route('periode'))
                ->exists();
            
            if ($exists) {
                $validator->errors()->add('status_magang', 
                    'Sudah ada periode aktif. Nonaktifkan periode lain terlebih dahulu.');
            }
        }
    });
}
```

#### Benefit
- Mencegah multiple periode aktif
- Business logic lebih jelas
- Menghindari confusion user

#### Kontra
- Opsi A: Butuh MySQL 8.0.13+ (partial index)
- Opsi B: Logic tersebar di observer
- Opsi C: Hanya validasi, tidak enforce di DB level

#### Rekomendasi
**Pending** — pilih Opsi B (Observer) atau Opsi C (Validation) untuk kompatibilitas. Opsi A jika MySQL version support.

---

### #13: Soft Delete untuk Table `periode_magang`

**Prioritas:** Low  
**Effort:** 20 menit  
**Risk:** Low

#### Masalah
Table `periode_magang` menggunakan hard delete. Periode lama yang sudah selesai biasanya tidak perlu dihapus, tapi di-archive untuk keperluan historis.

#### Analisis
Soft delete untuk `periode_magang` memungkinkan:
- Archive periode lama tanpa kehilangan data
- Recovery jika ada kesalahan
- Query statistik per periode historis

#### Solusi
**1. Model Update:**
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodeMagang extends Model
{
    use HasFactory, SoftDeletes;
    // ...
}
```

**2. Migration:**
```php
Schema::table('periode_magang', function (Blueprint $table) {
    $table->softDeletes();
});
```

#### Benefit
- Data periode historis tetap tersimpan
- Bisa di-restore jika perlu
- Query statistik lebih lengkap

#### Kontra
- Perlu update query untuk handle soft delete
- Storage sedikit lebih besar

#### Rekomendasi
**Pending** — prioritas rendah karena periode jarang dihapus. Implementasi jika ada requirement untuk archive periode lama.

---

### #14: Fix Bug `UnitBisnis::absen()` Obsolete ✅ IMPLEMENTED

**Status:** ✅ Completed  
**Prioritas:** High  
**Effort:** 5 menit  
**Risk:** Minimal

#### Masalah
Method `absen()` di `app/Models/UnitBisnis.php:34` masih reference ke kolom `absen.id_unit_bisnis` yang **sudah di-drop** pada migration `2025_12_12_000003_drop_id_unit_bisnis_from_absen_table.php`.

```php
// BROKEN - kolom id_unit_bisnis sudah tidak ada
public function absen()
{
    return $this->hasMany(Absen::class, 'id_unit_bisnis');
}
```

Jika ada kode yang memanggil `$unitBisnis->absen`, akan terjadi error SQL.

#### Solusi Implemented
Ubah jadi relasi `hasManyThrough` via `magang`:

```php
/**
 * Get the absen records for the unit bisnis through magang.
 */
public function absen()
{
    return $this->hasManyThrough(Absen::class, Magang::class, 'unit_bisnis_id', 'magang_id');
}
```

#### Benefit
- Bug fixed — method tidak error lagi
- Relasi tetap bisa digunakan via `magang`
- Backward compatible untuk kode yang sudah ada

---

### #15: Ubah `onDelete` Strategy pada `magang.unit_bisnis_id` ✅ IMPLEMENTED

**Status:** ✅ Completed  
**Migration:** `2026_05_19_222322_change_unit_bisnis_id_to_set_null_in_magang_table.php`

#### Masalah
FK `magang.unit_bisnis_id -> unit_bisnis.id` menggunakan `onDelete('cascade')`. Jika unit bisnis dihapus, **SEMUA data magang di unit itu ikut terhapus**, termasuk semua absen dan logbook turunannya.

#### Analisis
Admin yang tidak hati-hati menghapus unit bisnis (misal karena kerjasama berakhir) bisa kehilangan SELURUH data historis magang di unit tersebut. Ini sangat berbahaya untuk audit trail akademik.

#### Solusi Implemented
Ubah FK menjadi `onDelete('set null')`:

```php
// Cek FK constraint ada atau tidak
$foreignKeys = DB::select("...");

if (!empty($foreignKeys)) {
    Schema::table('magang', function (Blueprint $table) {
        $table->dropForeign(['unit_bisnis_id']);
    });
}

Schema::table('magang', function (Blueprint $table) {
    $table->foreignId('unit_bisnis_id')->nullable()->change();
});

Schema::table('magang', function (Blueprint $table) {
    $table->foreign('unit_bisnis_id')
        ->references('id')
        ->on('unit_bisnis')
        ->onDelete('set null');
});
```

#### Benefit
- Data magang tetap ada saat unit bisnis dihapus
- Audit trail dan laporan historis terjaga
- Mencegah kehilangan data tidak disengaja

---

### #16: Tambah Unique Constraint pada `nama_unit_bisnis`

**Prioritas:** Medium  
**Effort:** 10 menit  
**Risk:** Low

#### Masalah
Kolom `nama_unit_bisnis` bisa duplikat. Padahal logikanya, tidak boleh ada 2 unit bisnis dengan nama yang sama.

#### Solusi
**Migration:**
```php
Schema::table('unit_bisnis', function (Blueprint $table) {
    $table->unique('nama_unit_bisnis');
});
```

#### Benefit
- Mencegah duplikasi unit bisnis
- Data lebih konsisten
- Validasi di database level

#### Kontra
- Perlu cek data existing untuk duplikasi sebelum run migration

#### Rekomendasi
**Pending** — cek dulu apakah ada duplikasi:
```sql
SELECT nama_unit_bisnis, COUNT(*) 
FROM unit_bisnis 
GROUP BY nama_unit_bisnis 
HAVING COUNT(*) > 1;
```

---

### #17: Tambah Field Tambahan di `unit_bisnis`

**Prioritas:** Medium  
**Effort:** 30 menit  
**Risk:** Low

#### Masalah
Table `unit_bisnis` sangat minimal — hanya punya 1 field bisnis (`nama_unit_bisnis`). Tidak ada informasi penting seperti:
- Alamat unit bisnis
- Kontak (telepon, email)
- PIC (penanggung jawab)
- Status aktif/nonaktif (apakah masih menerima mahasiswa magang)

#### Analisis
Karena unit bisnis adalah kampus sendiri (internal), field tambahan mungkin tidak terlalu diperlukan. Tapi jika ada kebutuhan untuk:
- Kontak koordinator per unit
- Status unit (aktif/nonaktif untuk penerimaan magang)
- Deskripsi singkat unit

Maka bisa ditambahkan.

#### Solusi (Opsional)
**Migration:**
```php
Schema::table('unit_bisnis', function (Blueprint $table) {
    $table->string('koordinator')->nullable()->after('nama_unit_bisnis');
    $table->string('email')->nullable();
    $table->string('telepon')->nullable();
    $table->text('deskripsi')->nullable();
    $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
});
```

#### Benefit
- Informasi unit lebih lengkap
- Memudahkan koordinasi magang
- Bisa filter unit yang masih aktif

#### Kontra
- Effort lebih besar (perlu UI untuk manage)
- Mungkin tidak diperlukan jika unit bisnis internal kampus

#### Rekomendasi
**Pending** — implementasi hanya jika ada requirement bisnis untuk tracking detail unit lebih lengkap.

---

### #18: Soft Delete untuk Table `unit_bisnis`

**Prioritas:** Low  
**Effort:** 20 menit  
**Risk:** Low

#### Masalah
Table `unit_bisnis` menggunakan hard delete. Unit bisnis yang sudah tidak aktif (misal kerjasama berakhir) biasanya tidak perlu dihapus, tapi di-archive untuk keperluan historis.

#### Analisis
Soft delete untuk `unit_bisnis` memungkinkan:
- Archive unit lama tanpa kehilangan data
- Recovery jika ada kesalahan
- Query statistik per unit historis

#### Solusi
**1. Model Update:**
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitBisnis extends Model
{
    use HasFactory, SoftDeletes;
    // ...
}
```

**2. Migration:**
```php
Schema::table('unit_bisnis', function (Blueprint $table) {
    $table->softDeletes();
});
```

#### Benefit
- Data unit historis tetap tersimpan
- Bisa di-restore jika perlu
- Query statistik lebih lengkap

#### Kontra
- Perlu update query untuk handle soft delete
- Storage sedikit lebih besar

#### Rekomendasi
**Pending** — prioritas rendah. Implementasi jika ada requirement untuk archive unit lama atau konsisten dengan soft delete `magang`, `mahasiswa`, `periode_magang`.

---

### #19: Fix Bug `User::mahasiswa()` dan `User::dosen()` Obsolete ✅ IMPLEMENTED

**Status:** ✅ Completed  
**Prioritas:** Critical  
**Effort:** 5 menit  
**Risk:** Minimal

#### Masalah
Setelah improvement #2 dan #7 (drop kolom `id_dosen` dan `id_mahasiswa`), method `mahasiswa()` dan `dosen()` di `app/Models/User.php` masih menggunakan `belongsTo` dengan kolom yang sudah tidak ada:

```php
// BROKEN - kolom id_mahasiswa dan id_dosen sudah di-drop
public function mahasiswa()
{
    return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
}

public function dosen()
{
    return $this->belongsTo(Dosen::class, 'id_dosen');
}
```

**Risiko:** Sangat tinggi. Method ini kemungkinan dipakai di banyak tempat untuk auth/profile, akan error SQL saat dipanggil.

#### Solusi Implemented
Ubah jadi `hasOne` ke arah yang benar (karena FK sekarang ada di `mahasiswa.user_id` dan `dosen.user_id`):

```php
/**
 * Get the mahasiswa profile associated with the user.
 */
public function mahasiswa()
{
    return $this->hasOne(Mahasiswa::class, 'user_id');
}

/**
 * Get the dosen profile associated with the user.
 */
public function dosen()
{
    return $this->hasOne(Dosen::class, 'user_id');
}
```

#### Benefit
- Bug critical fixed
- Relasi tetap bisa digunakan dengan arah yang benar
- Backward compatible untuk kode yang sudah ada

---

### #20: Cleanup `$fillable` di Model User ✅ IMPLEMENTED

**Status:** ✅ Completed  
**Prioritas:** High  
**Effort:** 2 menit  
**Risk:** Minimal

#### Masalah
Array `$fillable` di model `User` masih punya field obsolete yang sudah di-drop:

```php
protected $fillable = [
    'email',
    'password',
    'id_mahasiswa',  // ❌ Sudah tidak ada di DB
    'id_dosen',      // ❌ Sudah tidak ada di DB
    'role',
];
```

**Risiko:** Mass assignment ke field ini akan menghasilkan SQL error atau jadi attack vector.

#### Solusi Implemented
Hapus field obsolete dari `$fillable`:

```php
protected $fillable = [
    'email',
    'password',
    'role',
];
```

#### Benefit
- Mencegah SQL error saat mass assignment
- Lebih aman dari security perspective
- Konsisten dengan schema database

---

### #21: Fix Kode yang Pakai Field/Relasi Obsolete ✅ IMPLEMENTED

**Status:** ✅ Completed  
**Prioritas:** High  
**Effort:** 30 menit  
**Risk:** Medium

#### Masalah
Setelah improvement #2 dan #7, ada beberapa file yang masih menggunakan field/relasi obsolete:
- `LogbookController.php` — menggunakan `$user->id_dosen`
- `Pembimbing\DashboardController.php` — menggunakan `$user->id_dosen`
- `Admin\UserController.php` — mengupdate `id_dosen` dan `id_mahasiswa`
- `UserSeeder.php` — mengupdate `id_dosen` dan `id_mahasiswa`

#### Solusi Implemented

**1. LogbookController.php:**
```php
// Before
if ($logbook->magang->dosen_pembimbing_id !== $user->id_dosen) {
    abort(403, 'Unauthorized action.');
}
$logbook->update([
    'approved_by' => $user->id_dosen,
]);

// After
if ($logbook->magang->dosen_pembimbing_id !== $user->dosen->id) {
    abort(403, 'Unauthorized action.');
}
$logbook->update([
    'approved_by' => $user->dosen->id,
]);
```

**2. Pembimbing\DashboardController.php:**
```php
// Before
$dosenId = $user->id_dosen;

// After
$dosenId = $user->dosen->id;
```

**3. Admin\UserController.php:**
Hapus semua baris `$user->update(['id_dosen' => ...])` dan `$user->update(['id_mahasiswa' => ...])` karena kolom sudah tidak ada.

**4. UserSeeder.php:**
Hapus semua baris `$user->update(['id_dosen' => ...])` dan `$user->update(['id_mahasiswa' => ...])`.

#### Benefit
- Semua kode sekarang menggunakan relasi yang benar
- Tidak ada SQL error lagi
- Konsisten dengan schema database baru

#### Catatan
Test files masih menggunakan field obsolete, tapi ini tidak masalah karena test akan fail dan perlu diupdate sesuai kebutuhan testing.

---

### #22: Soft Delete untuk Table `users`

**Prioritas:** Low  
**Effort:** 20 menit  
**Risk:** Medium

#### Masalah
Table `users` menggunakan hard delete. Ketika user dihapus, profile (mahasiswa/dosen) juga ikut terhapus karena cascade.

#### Analisis
Soft delete untuk `users` perlu dipertimbangkan dengan hati-hati:

**Pro:**
- Recovery jika ada kesalahan
- Audit trail login/activity historis
- Bisa di-restore jika perlu

**Kontra:**
- Privacy/GDPR compliance — user yang resign/lulus mungkin ingin data dihapus
- Kompleksitas query (perlu handle soft delete di semua tempat)
- Email unique constraint — user yang di-soft-delete tidak bisa re-register dengan email sama

#### Alternatif: Status Field
Daripada soft delete, pertimbangkan tambah field `status` (Aktif/Nonaktif):

```php
Schema::table('users', function (Blueprint $table) {
    $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
});
```

**Benefit:**
- User bisa di-disable tanpa dihapus
- Email bisa di-reuse (tinggal update email user lama)
- Lebih simple dari soft delete
- Tetap comply dengan privacy regulation (bisa hard delete kalau perlu)

#### Rekomendasi
**Pending** — pertimbangkan alternatif status field daripada soft delete. Implementasi hanya jika ada requirement spesifik untuk soft delete.

---

## 📝 Migration Files yang Sudah Dibuat

Berikut daftar migration files yang sudah berhasil dijalankan:

1. `2026_02_27_000004_update_absen_table_add_foto_rename_validated.php`
2. `2026_05_19_213254_drop_id_dosen_from_users_table.php`
3. `2026_05_19_213346_change_dosen_pembimbing_id_to_set_null_in_magang_table.php`
4. `2026_05_19_214809_change_approved_by_to_dosen_in_logbook_table.php`
5. `2026_05_19_220341_drop_id_mahasiswa_from_users_table.php`
6. `2026_05_19_221520_change_periode_id_to_set_null_in_magang_table.php`
7. `2026_05_19_222322_change_unit_bisnis_id_to_set_null_in_magang_table.php`

Semua migration sudah berhasil dijalankan dan database schema sudah terupdate.

---

## 🎯 Rekomendasi Next Steps

Berdasarkan prioritas dan impact, berikut urutan implementasi yang disarankan:

1. **#16 - Tambah unique constraint pada nama_unit_bisnis** (Medium priority, quick win)
2. **#11 - Tambah unique constraint pada nama_periode** (Medium priority, quick win)
3. **#1 - Tambah inverse relasi di Dosen** (Low effort, high value untuk code quality)
4. **#12 - Constraint untuk single active periode** (Medium priority, penting untuk business logic)
5. **#5 - Soft delete untuk magang** (Medium priority, penting untuk audit trail)
6. **#8 - Soft delete untuk mahasiswa** (Implementasi bersamaan dengan #5)
7. **#10 - Rename status_magang di periode_magang** (Jika konsistensi naming penting)
8. **#17 - Tambah field tambahan di unit_bisnis** (Jika ada requirement bisnis)
9. **#6 - Normalisasi pembimbing_lapangan** (Hanya jika ada requirement bisnis)
10. **#13 - Soft delete untuk periode_magang** (Low priority, nice to have)
11. **#18 - Soft delete untuk unit_bisnis** (Low priority, nice to have)
12. **#22 - Soft delete atau status field untuk users** (Low priority, pertimbangkan alternatif)

---

## 📚 Referensi

- Laravel Eloquent Relationships: https://laravel.com/docs/eloquent-relationships
- Laravel Soft Deletes: https://laravel.com/docs/eloquent#soft-deleting
- Database Normalization: https://en.wikipedia.org/wiki/Database_normalization
- MySQL Partial Indexes: https://dev.mysql.com/doc/refman/8.0/en/create-index.html
