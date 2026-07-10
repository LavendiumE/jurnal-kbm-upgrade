<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaIzinKeluar extends Model
{
    protected $fillable = [
        'nama',
        'nis',
        'kelas',
        'kelas_id',
        'keperluan',
        'jam_izin',
        'jam_kembali',
        'paraf_guru',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}