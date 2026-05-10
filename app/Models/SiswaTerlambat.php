<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaTerlambat extends Model
{
    protected $table = 'siswa_terlambats';

    protected $fillable = [
        'nama_siswa',
        'nis',
        'kelas_id',
        'jam_terlambat',
        'cuaca',
        'alasan',
        'guru_pembina_id',
        'pembinaan',
        'user_id',
        'paraf_guru',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guruPembina()
    {
        return $this->belongsTo(Guru::class, 'guru_pembina_id');
    }
}