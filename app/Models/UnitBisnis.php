<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitBisnis extends Model
{
    use HasFactory;

    protected $table = 'unit_bisnis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_unit_bisnis',
    ];

    /**
     * Get the magang records for the unit bisnis.
     */
    public function magang()
    {
        return $this->hasMany(Magang::class, 'unit_id');
    }

    /**
     * Get the absen records for the unit bisnis.
     */
    public function absen()
    {
        return $this->hasMany(Absen::class, 'id_unit_bisnis');
    }
}
