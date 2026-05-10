<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $fillable = [
        'nama',
    ];

    // relasi ke jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}