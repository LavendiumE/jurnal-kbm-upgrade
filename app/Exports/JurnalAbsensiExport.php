<?php

namespace App\Exports;

use App\Models\Jurnal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JurnalAbsensiExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected int $jurnalId;

    public function __construct(int $jurnalId)
    {
        $this->jurnalId = $jurnalId;
    }

    public function collection(): Collection
    {
        $jurnal = Jurnal::with([
            'guru',
            'kelas',
            'jadwal.ruangan',
            'jadwal.mapel',
            'absensis.siswa',
        ])->findOrFail($this->jurnalId);

        return $jurnal->absensis
            ->sortBy('siswa.nama')
            ->values()
            ->map(function ($absensi, $index) use ($jurnal) {

                return [

                    'No' =>
                        $index + 1,

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

                    'NIS' =>
                        $absensi->siswa->nis ?? '-',

                    'Nama Siswa' =>
                        $absensi->siswa->nama ?? '-',

                    'Status' =>
                        ucfirst($absensi->status),

                    'Alasan / Keterangan' =>
                        $absensi->alasan ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Kelas',
            'Ruang',
            'Guru',
            'Mata Pelajaran',
            'NIS',
            'Nama Siswa',
            'Status',
            'Alasan / Keterangan',
        ];
    }
}