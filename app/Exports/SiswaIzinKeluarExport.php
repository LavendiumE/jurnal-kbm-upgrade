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
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct($tanggalAwal = null, $tanggalAkhir = null)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection()
    {
        $query = SiswaIzinKeluar::latest();

        if ($this->tanggalAwal && $this->tanggalAkhir) {

           $query->whereBetween('tanggal', [
                $this->tanggalAwal,
                $this->tanggalAkhir,
            ]);

        }

        return $query->get();
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
            'Jam Keluar',
            'Jam Kembali',
            'Paraf Guru',
            'Tanggal',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->tanggal,
            $row->nama,
            $row->nis,
            $row->kelas,
            $row->keperluan,
            $row->jam_izin,
            $row->jam_kembali,

            $row->paraf_guru
                ? asset('storage/' . $row->paraf_guru)
                : '-',

            $row->created_at
                ? $row->created_at->format('d-m-Y')
                : '-',
        ];
    }
}