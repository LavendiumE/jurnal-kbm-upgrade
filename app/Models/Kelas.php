<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama',
        'jurusan_id',
    ];

    // relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // relasi ke jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    // relasi ke jurnal
    public function jurnals()
    {
        return $this->hasMany(Jurnal::class);
    }

    // relasi ke keterlambatan
    public function keterlambatans()
    {
        return $this->hasMany(Keterlambatan::class);
    }

    // relasi ke izin keluar
    public function izinKeluars()
    {
        return $this->hasMany(IzinKeluar::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}