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

        // PJJ / Daring
        'is_daring',
        'pjj_menggunakan',
        'pjj_lainnya',

        // Rekap Absensi
        'hadir',
        'izin',
        'sakit',
        'alfa',
        'pkl',

        'foto',
    ];

    protected $casts = [
        'is_daring' => 'boolean',
        'pjj_menggunakan' => 'array',
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

    public function absensis()
    {
        return $this->hasMany(JurnalAbsensi::class);
    }
}