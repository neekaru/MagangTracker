<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'magang_id',
        'jenis_absen',
        'tanggal',
        'jam',
        'status_kehadiran',
        'status_validasi',
        'validated_by',
        'validated_at',
        'keterangan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'jam' => 'datetime:H:i',
            'validated_at' => 'datetime',
        ];
    }

    /**
     * Get the magang that owns the absen.
     */
    public function magang()
    {
        return $this->belongsTo(Magang::class, 'magang_id');
    }

    /**
     * Get the dosen who validated the absen.
     */
    public function validator()
    {
        return $this->belongsTo(Dosen::class, 'validated_by');
    }

    /**
     * Accessor for jam_masuk (maps to jam).
     */
    public function getJamMasukAttribute()
    {
        return $this->jam;
    }

    /**
     * Accessor for status_absensi (maps to status_kehadiran).
     */
    public function getStatusAbsensiAttribute()
    {
        return $this->status_kehadiran;
    }
}
