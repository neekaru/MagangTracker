<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'logbook';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'magang_id',
        'tanggal_logbook',
        'jam_mulai',
        'jam_selesai',
        'deskripsi_kegiatan',
        'hasil_kegiatan',
        'foto_kegiatan',
        'status',
        'approved_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_logbook' => 'datetime',
        ];
    }

    /**
     * Get the magang that owns the logbook.
     */
    public function magang()
    {
        return $this->belongsTo(Magang::class, 'magang_id');
    }

    /**
     * Get the user who approved the logbook.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
