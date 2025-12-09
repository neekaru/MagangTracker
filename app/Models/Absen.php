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
        'id_unit_bisnis',
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
            'validated_at' => 'datetime',
        ];
    }

    /**
     * Get the unit bisnis that owns the absen.
     */
    public function unitBisnis()
    {
        return $this->belongsTo(UnitBisnis::class, 'id_unit_bisnis');
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
}
