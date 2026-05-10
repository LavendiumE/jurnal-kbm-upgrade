<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'nama',
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke jurnal
    public function jurnals()
    {
        return $this->hasMany(Jurnal::class);
    }

    // relasi ke jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}