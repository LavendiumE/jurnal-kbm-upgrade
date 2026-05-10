<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinKeluar extends Model
{
    protected $fillable = [
        'nama_siswa',
        'kelas_id',
        'keterangan',
        'waktu',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}