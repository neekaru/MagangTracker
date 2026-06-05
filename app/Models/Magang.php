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
        'mahasiswa_id',
        'unit_bisnis_id',
        'periode_id',
        'dosen_pembimbing_id',
        'pembimbing_lapangan',
        'status_magang',
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
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Get the unit bisnis that owns the magang.
     */
    public function unitBisnis()
    {
        return $this->belongsTo(UnitBisnis::class, 'unit_bisnis_id');
    }

    /**
     * Get the periode magang that owns the magang.
     */
    public function periodeMagang()
    {
        return $this->belongsTo(PeriodeMagang::class, 'periode_id');
    }

    /**
     * Get the dosen pembimbing that supervises the magang.
     */
    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_id');
    }

    /**
     * Alias relasi dosen() agar backward-compatible dengan kode lama.
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_id');
    }

    /**
     * Get the logbook records for the magang.
     */
    public function logbook()
    {
        return $this->hasMany(Logbook::class, 'magang_id');
    }

    /**
     * Get the absen records for the magang.
     */
    public function absen()
    {
        return $this->hasMany(Absen::class, 'magang_id');
    }
}

