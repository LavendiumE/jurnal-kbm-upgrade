<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;

class SiswaImport implements
    OnEachRow,
    WithHeadingRow,
    WithChunkReading
{
    protected array $kelasMap = [];

    public function __construct()
    {
        $this->kelasMap = Kelas::pluck('id', 'nama')
            ->mapWithKeys(function ($id, $nama) {
                return [
                    $this->normalize($nama) => $id
                ];
            })
            ->toArray();
    }

    public function onRow(Row $row)
    {
        $data = $row->toArray();

        // Lewati baris kosong
        if (
            empty($data['nis']) &&
            empty($data['nama']) &&
            empty($data['kelas'])
        ) {
            return;
        }

        $nis = trim((string) ($data['nis'] ?? ''));
        $nama = trim((string) ($data['nama'] ?? ''));
        $namaKelas = trim((string) ($data['kelas'] ?? ''));

        // Validasi data wajib
        if ($nis === '') {
            throw new \Exception(
                "NIS kosong pada baris {$row->getIndex()}."
            );
        }

        if ($nama === '') {
            throw new \Exception(
                "Nama siswa kosong pada baris {$row->getIndex()}."
            );
        }

        if ($namaKelas === '') {
            throw new \Exception(
                "Kelas kosong pada baris {$row->getIndex()}."
            );
        }

        // Cari kelas berdasarkan nama
        $kelasKey = $this->normalize($namaKelas);

        $kelasId = $this->kelasMap[$kelasKey] ?? null;

        if (!$kelasId) {
            throw new \Exception(
                "Kelas '{$namaKelas}' tidak ditemukan di database pada baris {$row->getIndex()}."
            );
        }

        $noHp = !empty($data['no_hp'])
            ? trim((string) $data['no_hp'])
            : null;

        /*
         * Jika NIS sudah ada:
         *     UPDATE
         *
         * Jika NIS belum ada:
         *     CREATE
         */
        Siswa::updateOrCreate(
            [
                'nis' => $nis,
            ],
            [
                'nama' => $nama,
                'kelas_id' => $kelasId,
                'no_hp' => $noHp,
            ]
        );
    }

    /**
     * Normalisasi nama kelas
     * supaya perbedaan huruf besar/kecil atau spasi
     * tidak membuat kelas dianggap berbeda.
     */
    protected function normalize(string $value): string
    {
        return strtolower(
            preg_replace('/\s+/', ' ', trim($value))
        );
    }

    public function chunkSize(): int
    {
        return 500;
    }
}