<?php

namespace App\Exports;

use App\Models\Jurnal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AllJurnalsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct(
        $tanggalAwal = null,
        $tanggalAkhir = null
    ) {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection(): Collection
    {
        $query = Jurnal::with([
            'guru.user',
            'kelas',
            'jadwal.ruangan',
            'jadwal.mapel'
        ])
        ->orderBy('created_at', 'asc');

        if ($this->tanggalAwal && $this->tanggalAkhir) {

            $query->whereBetween(
                'created_at',
                [
                   $this->tanggalAwal . ' 00:00:00',
                   $this->tanggalAkhir . ' 23:59:59',
                ]
            );
        }

        return $query->get()->map(function ($jurnal) {

            $fotoUrl = $jurnal->foto
                ? asset('storage/' . $jurnal->foto)
                : '';

            return [

                'Tanggal' =>
                    optional($jurnal->created_at)
                    ?->format('d-m-Y'),

                'Jam Mulai' =>
                    $jurnal->jadwal->jam_mulai ?? '-',

                'Jam Selesai' =>
                    $jurnal->jadwal->jam_selesai ?? '-',

                'Kelas' =>
                    $jurnal->kelas->nama ?? '-',

                'Ruang' =>
                    $jurnal->jadwal->ruangan->nama ?? '-',

                'Guru' =>
                    $jurnal->guru->nama ?? '-',

                'Mata Pelajaran' =>
                    $jurnal->jadwal->mapel->nama ?? '-',

                'Materi' =>
                    $jurnal->materi ?? '-',

                'Kegiatan' =>
                    $jurnal->kegiatan ?? '-',

                'Hadir' =>
                    $jurnal->hadir ?? 0,

                'Izin' =>
                    $jurnal->izin ?? 0,

                'Sakit' =>
                    $jurnal->sakit ?? 0,

                'Alfa' =>
                    $jurnal->alfa ?? 0,
                'PKL' =>
                    $jurnal->pkl ?? '-',

                'Foto' => $fotoUrl,
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
            'Pkl',
            'Foto',
        ];
    }
}