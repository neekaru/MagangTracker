<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nip',
    ];

    /**
     * Get the user that owns the dosen.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the magang records supervised by the dosen.
     */
    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_dosen');
    }

    /**
     * Get the penilaian records created by the dosen.
     */
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'dinilai_oleh_id');
    }
}
