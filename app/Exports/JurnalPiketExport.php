<?php

namespace App\Exports;

use App\Models\Jurnal;
use Illuminate\Support\Collection;
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
            'guru',
            'kelas',
            'jadwal.mapel',
            'jadwal.ruangan'
        ])
        ->where('tipe', 'piket')
        ->latest();

        if ($this->tanggalAwal && $this->tanggalAkhir) {

            $query->whereBetween(
                'created_at',
                [
                    $this->tanggalAwal . ' 00:00:00',
                    $this->tanggalAkhir . ' 23:59:59',
                ]
            );

        }

        return $query->get();
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
            'Ruangan',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            optional($row->created_at)->format('d-m-Y'),
            ucfirst($row->jadwal->hari ?? '-'),
            ($row->jadwal->jam_mulai ?? '-') . ' - ' . ($row->jadwal->jam_selesai ?? '-'),
            $row->kelas->nama ?? '-',
            $row->jadwal->mapel->nama ?? '-',
            $row->guru->nama ?? '-',
            $row->jadwal->ruangan->nama ?? '-',
        ];
    }
}