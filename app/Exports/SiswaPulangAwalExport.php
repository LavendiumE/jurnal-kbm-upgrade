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
    public function collection()
    {
        return SiswaPulangAwal::latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NIS',
            'Kelas',
            'Keperluan',
            'Jam Izin',
            'Paraf Guru',
            'Tanggal Dibuat'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->nama,
            $row->nis,
            $row->kelas,
            $row->keperluan,
            $row->jam_izin,

            $row->paraf_guru
                ? asset('storage/' . $row->paraf_guru)
                : '-',

            $row->created_at->format('d-m-Y H:i'),
        ];
    }
}