<?php

namespace App\Exports;

use App\Models\Jurnal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AllJurnalsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct($tanggalAwal = null, $tanggalAkhir = null)
    {
        $this->tanggalAwal  = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection()
    {
        $query = Jurnal::with(['guru.user', 'kelas', 'jadwal'])
            ->orderBy('tanggal_kbm', 'asc');

        if ($this->tanggalAwal && $this->tanggalAkhir) {
            $query->whereBetween('tanggal_kbm', [
                $this->tanggalAwal,
                $this->tanggalAkhir
            ]);
        }

        return $query->get()->map(function ($jurnal) {

            $fotoUrl = $jurnal->dokumentasi
                ? asset('storage/' . $jurnal->dokumentasi)
                : '';

            return [
                'Tanggal'        => optional($jurnal->tanggal_kbm)->format('d-m-Y'),
                'Jam Mulai'      => $jurnal->jam_mulai,
                'Jam Selesai'    => $jurnal->jam_selesai,
                'Kelas'          => $jurnal->kelas->nama ?? '-',
                'Ruang'          => $jurnal->ruang ?? '-',
                'Guru'           => $jurnal->guru->user->name ?? '-',
                'Mata Pelajaran' => $jurnal->jadwal->mata_pelajaran ?? '-',
                'Materi'         => $jurnal->materi,
                'Kegiatan'       => $jurnal->kegiatan,
                'Hadir'          => $jurnal->hadir,
                'Izin'           => $jurnal->izin,
                'Sakit'          => $jurnal->sakit,
                'Alfa'           => $jurnal->alfa,
                'Foto'           => $fotoUrl,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Kelas',
            'Ruang',
            'Guru',
            'Mata Pelajaran',
            'Materi',
            'Kegiatan',
            'Hadir',
            'Izin',
            'Sakit',
            'Alfa',
            'Foto',
        ];
    }
}