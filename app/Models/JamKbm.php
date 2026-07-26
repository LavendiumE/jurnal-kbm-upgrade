<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamKbm extends Model
{
    protected $table = 'jam_kbm';

    protected $fillable = [
        'hari',
        'jam_ke',
        'jam_mulai',
        'jam_selesai',
    ];
}