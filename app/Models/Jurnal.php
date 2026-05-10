<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $fillable = [
        'guru_id',
        'kelas_id',
        'jadwal_id',
        'tipe',
        'materi',
        'kegiatan',
        'hadir',
        'izin',
        'sakit',
        'alfa',
        'pkl',
        'foto',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}