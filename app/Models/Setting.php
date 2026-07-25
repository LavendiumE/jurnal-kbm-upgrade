<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'nama_sekolah',
        'teks_login',
        'logo',
        'batas_jurnal_menit',

        'jam1_mulai',
        'jam1_selesai',

        'jam2_mulai',
        'jam2_selesai',

        'jam3_mulai',
        'jam3_selesai',

        'jam4_mulai',
        'jam4_selesai',

        'jam5_mulai',
        'jam5_selesai',

        'jam6_mulai',
        'jam6_selesai',

        'jam7_mulai',
        'jam7_selesai',

        'jam8_mulai',
        'jam8_selesai',

        'jam9_mulai',
        'jam9_selesai',

        'jam10_mulai',
        'jam10_selesai',
    ];
}