<?php

namespace App\Exports;

use App\Models\Jurnal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AllJurnalsExport implements FromCollection, WithHeadings, ShouldAutoSize
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
            'guru.user',
            'kelas',
            'jadwal.ruangan',
            'jadwal.mapel'
        ])
        ->orderBy('created_at', 'asc');

        if ($this->tanggalAwal && $this->tanggalAkhir) {

            $query->whereBetween(
                'created_at',
                [
                    $this->tanggalAwal . ' 00:00:00',
                    $this->tanggalAkhir . ' 23:59:59',
                ]
            );
        }

        return $query->get()->map(function ($jurnal) {

            $fotoUrl = $jurnal->foto
                ? asset('storage/' . $jurnal->foto)
                : '';

            // Format metode PJJ
            $metodePjj = $jurnal->is_daring
                ? collect($jurnal->pjj_menggunakan ?? [])
                    ->map(function ($metode) {
                        return match ($metode) {
                            'wag' => 'WhatsApp Group (WAG)',
                            'google_meet' => 'Google Meet',
                            'zoom' => 'Zoom',
                            'google_classroom' => 'Google Classroom',
                            'lms' => 'LMS',
                            'lainnya' => 'Lainnya',
                            default => $metode,
                        };
                    })
                    ->implode(', ')
                : '-';

            return [

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

                'PJJ / Daring' =>
                    $jurnal->is_daring ? 'Ya' : 'Tidak',

                'Metode PJJ' =>
                    $metodePjj,

                'PJJ Lainnya' =>
                    $jurnal->pjj_lainnya ?? '-',

                'Guru' =>
                    $jurnal->guru->nama ?? '-',

                'Mata Pelajaran' =>
                    $jurnal->jadwal->mapel->nama ?? '-',

                'Materi' =>
                    $jurnal->materi ?? '-',

                'Kegiatan' =>
                    $jurnal->kegiatan ?? '-',

                'Hadir' =>
                    $jurnal->absensis
                        ->where('status', 'hadir')
                        ->count(),

                'Izin' =>
                    $jurnal->absensis
                        ->where('status', 'izin')
                        ->count(),

                'Sakit' =>
                    $jurnal->absensis
                        ->where('status', 'sakit')
                        ->count(),

                'Alfa' =>
                    $jurnal->absensis
                        ->where('status', 'alfa')
                        ->count(),

                'PKL' =>
                    $jurnal->absensis
                        ->where('status', 'pkl')
                        ->count(),

                'Dispensasi' =>
                    $jurnal->absensis
                        ->where('status', 'dispensasi')
                        ->count(),

                'Foto' => $fotoUrl,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Kelas',
            'Ruang',
            'PJJ / Daring',
            'Metode PJJ',
            'PJJ Lainnya',
            'Guru',
            'Mata Pelajaran',
            'Materi',
            'Kegiatan',
            'Hadir',
            'Izin',
            'Sakit',
            'Alfa',
            'PKL',
            'Dispensasi',
            'Foto',
        ];
    }
}