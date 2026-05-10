<?php

namespace App\Exports;

use App\Models\Jadwal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class JadwalExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection(): Collection
    {
        $hariOrder = [
            'senin' => 1,
            'selasa' => 2,
            'rabu' => 3,
            'kamis' => 4,
            'jumat' => 5,
            'sabtu' => 6,
        ];

        return Jadwal::with([
            'guru',
            'kelas',
            'mapel',
            'ruangan'
        ])
        ->get()
        ->sort(function ($a, $b) use ($hariOrder) {

            $hariA = $hariOrder[$a->hari] ?? 99;
            $hariB = $hariOrder[$b->hari] ?? 99;

            if ($hariA === $hariB) {
                return $a->jam_ke <=> $b->jam_ke;
            }

            return $hariA <=> $hariB;
        })
        ->values()
        ->map(function ($jadwal) {

            return [
                'Hari'        => ucfirst($jadwal->hari),
                'Jam Ke'      => $jadwal->jam_ke,
                'Jam Mulai'   => $jadwal->jam_mulai,
                'Jam Selesai' => $jadwal->jam_selesai,
                'Kelas'       => $jadwal->kelas->nama ?? '-',
                'Mapel'       => $jadwal->mapel->nama ?? '-',
                'Guru'        => $jadwal->guru->nama ?? '-',
                'Ruangan'     => $jadwal->ruangan->nama ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Hari',
            'Jam Ke',
            'Jam Mulai',
            'Jam Selesai',
            'Kelas',
            'Mata Pelajaran',
            'Guru',
            'Ruangan',
        ];
    }
}