<?php

namespace App\Exports;

use App\Models\SiswaIzinKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaIzinKeluarExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    public function collection()
    {
        return SiswaIzinKeluar::latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NIS',
            'Kelas',
            'Alasan',
            'Jam Izin',
            'Jam Kembali',
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
            $row->alasan,
            $row->jam_izin,
            $row->jam_kembali,

            $row->paraf_guru
                ? asset('storage/' . $row->paraf_guru)
                : '-',

            $row->created_at->format('d-m-Y H:i'),
        ];
    }
}