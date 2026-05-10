<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaPulangAwal extends Model
{
    protected $fillable = [
        'nama',
        'nis',
        'kelas',
        'jam_izin',
        'keperluan',
        'paraf_guru',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}