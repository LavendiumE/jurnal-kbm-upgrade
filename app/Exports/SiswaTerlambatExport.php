<?php

namespace App\Exports;

use App\Models\SiswaTerlambat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaTerlambatExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    public function collection()
    {
        return SiswaTerlambat::with('kelas')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Jam Terlambat',
            'Cuaca',
            'Alasan',
            'Pembinaan',
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
            $row->nama_siswa,
            $row->nis,
            $row->kelas->nama ?? '-',
            $row->jam_terlambat,
            $row->cuaca,
            $row->alasan,
            $row->pembinaan,

            $row->paraf_guru
                ? asset('storage/' . $row->paraf_guru)
                : '-',

            $row->created_at->format('d-m-Y H:i'),
        ];
    }
}