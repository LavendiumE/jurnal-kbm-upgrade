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
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct($tanggalAwal = null, $tanggalAkhir = null)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection()
    {
        return SiswaTerlambat::with('kelas')
            ->when(
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
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Jam Terlambat',
            'Cuaca',
            'Alasan',
            'Pembinaan',
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
        ];
    }
}