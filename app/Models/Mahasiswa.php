<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nim',
        'nama_lengkap',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the mahasiswa.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the magang records for the mahasiswa.
     */
    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_mahasiswa');
    }

    /**
     * Get the penilaian records for the mahasiswa.
     */
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'mahasiswa_id');
    }
}
