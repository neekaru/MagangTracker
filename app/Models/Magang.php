<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;

    protected $table = 'magang';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_mahasiswa',
        'unit_id',
        'periode_id',
        'id_dosen',
        'pembimbing_lapangan',
        'status_magang',
        'target_book_mingguan',
        'tugas_description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    /**
     * Get the mahasiswa that owns the magang.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    /**
     * Get the unit bisnis that owns the magang.
     */
    public function unitBisnis()
    {
        return $this->belongsTo(UnitBisnis::class, 'unit_id');
    }

    /**
     * Get the periode magang that owns the magang.
     */
    public function periodeMagang()
    {
        return $this->belongsTo(PeriodeMagang::class, 'periode_id');
    }

    /**
     * Get the dosen that supervises the magang.
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }

    /**
     * Get the logbook records for the magang.
     */
    public function logbook()
    {
        return $this->hasMany(Logbook::class, 'magang_id');
    }

    /**
     * Get the penilaian records for the magang.
     */
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'magang_id');
    }

    /**
     * Get the absen records for the magang.
     */
    public function absen()
    {
        return $this->hasMany(Absen::class, 'magang_id');
    }
}
