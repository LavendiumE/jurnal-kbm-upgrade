<?php

namespace App\Exports;

use App\Models\Jurnal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JurnalPiketExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    public function collection()
    {
        return Jurnal::with(['guru', 'kelas', 'jadwal.mapel', 'jadwal.ruangan'])
            ->where('tipe', 'piket')
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Hari',
            'Jam',
            'Kelas',
            'Mapel',
            'Guru',
            'Ruangan'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->created_at->format('d-m-Y'),
            ucfirst($row->jadwal->hari ?? '-'),
            ($row->jadwal->jam_mulai ?? '-') . ' - ' . ($row->jadwal->jam_selesai ?? '-'),
            $row->kelas->nama ?? '-',
            $row->jadwal->mapel->nama ?? '-',
            $row->guru->nama ?? '-',
            $row->jadwal->ruangan->nama ?? '-',
        ];
    }
}