<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nis',
        'nama',
        'kelas_id',
        'no_hp',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}