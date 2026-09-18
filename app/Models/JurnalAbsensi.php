<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalAbsensi extends Model
{
    protected $table = 'jurnal_absensis';

    protected $fillable = [
        'jurnal_id',
        'siswa_id',
        'status',
        'alasan',
    ];

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}