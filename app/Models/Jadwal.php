<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mapel_id',
        'ruangan_id',
        'hari',
        'jam_ke',
        'jam_mulai',
        'jam_selesai',

        'use_default_batas_jurnal',
        'batas_jurnal_menit',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}