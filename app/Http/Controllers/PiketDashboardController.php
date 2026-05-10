<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Jurnal;
use App\Models\SiswaIzinKeluar;
use App\Models\SiswaPulangAwal;
use App\Models\SiswaTerlambat;
use App\Models\Informasi;

class PiketDashboardController extends Controller
{
    public function index()
    {
        $hari = strtolower(now()->locale('id')->translatedFormat('l'));

        $jadwalsHariIni = Jadwal::with(['kelas', 'mapel', 'guru', 'ruangan'])
            ->where('hari', $hari)
            ->orderBy('jam_ke')
            ->get();

        $jumlahJurnal = Jurnal::whereDate('created_at', today())
            ->where('tipe', 'piket')
            ->count();

        $jumlahPerizinan =
            SiswaIzinKeluar::whereDate('created_at', today())->count()
            +
            SiswaPulangAwal::whereDate('created_at', today())->count();

        $jumlahTerlambat = SiswaTerlambat::whereDate('created_at', today())->count();

        $aktivitas = collect([
            ...SiswaIzinKeluar::latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => $item->nama,
                    'kelas' => $item->kelas,
                    'jenis' => 'Izin Keluar',
                    'jam' => $item->jam_izin,
                ];
            }),

            ...SiswaPulangAwal::latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => $item->nama,
                    'kelas' => $item->kelas,
                    'jenis' => 'Izin Pulang',
                    'jam' => $item->jam_izin,
                ];
            }),

            ...SiswaTerlambat::latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => $item->nama_siswa,
                    'kelas' => optional($item->kelas)->nama,
                    'jenis' => 'Terlambat',
                    'jam' => $item->jam_terlambat,
                ];
            }),

        ])->sortByDesc('jam')->take(10);

        $informasi = Informasi::latest()->first();
        
        return view('piket.dashboard', compact(
            'jadwalsHariIni',
            'jumlahJurnal',
            'jumlahPerizinan',
            'jumlahTerlambat',
            'aktivitas',
            'informasi'
        ));
    }
}
