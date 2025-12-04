<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'magang_id',
        'mahasiswa_id',
        'dinilai_oleh_id',
        'nilai_kedisplinan',
        'nilai_tanggung_jawab',
        'nilai_kemampuan_teknis',
        'nilai_laporan_akhir',
        'nilai_prestasi',
        'catatan',
    ];

    /**
     * Get the magang that owns the penilaian.
     */
    public function magang()
    {
        return $this->belongsTo(Magang::class, 'magang_id');
    }

    /**
     * Get the mahasiswa that is being evaluated.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Get the dosen who evaluated.
     */
    public function penilai()
    {
        return $this->belongsTo(Dosen::class, 'dinilai_oleh_id');
    }
}
