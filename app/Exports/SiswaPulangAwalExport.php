<?php

namespace App\Exports;

use App\Models\SiswaPulangAwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaPulangAwalExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct($tanggalAwal = null, $tanggalAkhir = null)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection()
    {
        return SiswaPulangAwal::when(
                $this->tanggalAwal && $this->tanggalAkhir,
                function ($query) {
                    $query->whereBetween('tanggal', [
                        $this->tanggalAwal,
                        $this->tanggalAkhir
                    ]);
                }
            )
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama',
            'NIS',
            'Kelas',
            'Keperluan',
            'Jam Pulang',
            'Paraf Guru',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->tanggal
                ? \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y')
                : '-',

            $row->nama,
            $row->nis,
            $row->kelas,
            $row->keperluan,
            $row->jam_izin,

            $row->paraf_guru
                ? asset('storage/' . $row->paraf_guru)
                : '-',
        ];
    }
}