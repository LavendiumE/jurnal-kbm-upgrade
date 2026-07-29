<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jadwal;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Ruangan;
use App\Exports\JadwalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\JamKbm;
use App\Models\Setting;

class JadwalController extends Controller
{

    private function getJamPelajaran($hari)
    {
        $hari = ucfirst(strtolower($hari));

        return JamKbm::where('hari', $hari)
            ->orderBy('jam_ke')
            ->get()
            ->mapWithKeys(function ($jam) {
                return [
                    $jam->jam_ke => [
                        $jam->jam_mulai,
                        $jam->jam_selesai
                    ]
                ];
            })
            ->toArray();
    }

    public function getJamByHari($hari)
    {
        return response()->json(
            $this->getJamPelajaran($hari)
        );
    }

    public function index()
    {
        $jadwals = Jadwal::with(['guru', 'kelas', 'mapel', 'ruangan'])
            ->latest()
            ->paginate(10);

        $setting = Setting::first();

        return view('admin.jadwals.index', compact(
            'jadwals',
            'setting'
        ));
    }

    public function create()
    {
        $defaultJam = $this->getJamPelajaran('Senin');
        $setting = Setting::first();

        return view('admin.jadwals.create', [
            'gurus' => Guru::whereHas('user', function ($query) {
                $query->where('is_active', true);
            })->orderBy('nama')->get(),

            'kelas' => Kelas::all(),
            'mapels' => Mapel::all(),
            'ruangans' => Ruangan::all(),
            'defaultJam' => $defaultJam,
            'setting' => $setting,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'kelas_id' => 'required|exists:kelas,id',

            'jam_mulai.*' => 'nullable|date_format:H:i',
            'jam_selesai.*' => 'nullable|date_format:H:i',

            'use_default_batas_jurnal.*' => 'required|boolean',
            'batas_jurnal_menit.*' => 'nullable|integer|min:1',
        ]);

        $jam_pelajaran = $this->getJamPelajaran($request->hari);

        foreach ($request->jam_ke as $i => $jam) {

            if (
                empty($request->mapel_id[$i]) ||
                empty($request->guru_id[$i]) ||
                empty($request->ruangan_id[$i])
            ) {
                continue;
            }

            Jadwal::create([
                'hari' => strtolower($request->hari),
                'kelas_id' => $request->kelas_id,
                'mapel_id' => $request->mapel_id[$i],
                'guru_id' => $request->guru_id[$i],
                'ruangan_id' => $request->ruangan_id[$i],
                'jam_ke' => $jam,
                'jam_mulai' => !empty($request->jam_mulai[$i])
                    ? $request->jam_mulai[$i]
                    : ($jam_pelajaran[$jam][0] ?? null),

                'jam_selesai' => !empty($request->jam_selesai[$i])
                    ? $request->jam_selesai[$i]
                    : ($jam_pelajaran[$jam][1] ?? null),
                // ===== BATAS JURNAL =====
                'use_default_batas_jurnal' => $request->use_default_batas_jurnal[$i],

                'batas_jurnal_menit' =>
                    $request->use_default_batas_jurnal[$i]
                        ? null
                        : ($request->batas_jurnal_menit[$i] ?: null),
            ]);
        }

        return redirect()
            ->route('admin.jadwals.index')
            ->with('success', 'Jadwal berhasil disimpan');
    }

    public function edit(Jadwal $jadwal)
    {
        $defaultJam = $this->getJamPelajaran($jadwal->hari);
        $setting = Setting::first();

        $jadwals = Jadwal::where('kelas_id', $jadwal->kelas_id)
            ->where('hari', $jadwal->hari)
            ->get();

        return view('admin.jadwals.edit', [
            'jadwalGroup' => [
                'kelas_id' => $jadwal->kelas_id,
                'hari' => $jadwal->hari
            ],
            'jadwals' => $jadwals,
            'kelas' => Kelas::all(),
            'mapels' => Mapel::all(),
            'gurus' => Guru::whereHas('user', function ($query) {
                $query->where('is_active', true);
            })->orderBy('nama')->get(),
            'ruangans' => Ruangan::all(),
            'defaultJam' => $defaultJam,
            'setting' => $setting,
        ]);
    }

    public function update(Request $request, $group)
    {
        [$kelas_id, $hari] = explode('-', $group);

        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',

            'use_default_batas_jurnal.*' => 'required|boolean',
            'batas_jurnal_menit.*' => 'nullable|integer|min:1',
            'jam_mulai.*' => 'nullable|date_format:H:i',
            'jam_selesai.*' => 'nullable|date_format:H:i',
        ]);

        $jam_pelajaran = $this->getJamPelajaran($request->hari);

        foreach ($request->jam_ke as $i => $jam) {

            // Kalau satu baris dikosongkan
            if (
                empty($request->mapel_id[$i]) ||
                empty($request->guru_id[$i]) ||
                empty($request->ruangan_id[$i])
            ) {

                Jadwal::where('kelas_id', $kelas_id)
                    ->where('hari', $hari)
                    ->where('jam_ke', $jam)
                    ->delete();

                continue;
            }

            $jadwal = Jadwal::where('kelas_id', $kelas_id)
                ->where('hari', $hari)
                ->where('jam_ke', $jam)
                ->first();

            $data = [
                'hari' => strtolower($request->hari),
                'kelas_id' => $kelas_id,
                'mapel_id' => $request->mapel_id[$i],
                'guru_id' => $request->guru_id[$i],
                'ruangan_id' => $request->ruangan_id[$i],
                'jam_ke' => $jam,

                'jam_mulai' => !empty($request->jam_mulai[$i])
                    ? $request->jam_mulai[$i]
                    : ($jam_pelajaran[$jam][0] ?? null),

                'jam_selesai' => !empty($request->jam_selesai[$i])
                    ? $request->jam_selesai[$i]
                    : ($jam_pelajaran[$jam][1] ?? null),

                'use_default_batas_jurnal' => $request->use_default_batas_jurnal[$i],

                'batas_jurnal_menit' => $request->use_default_batas_jurnal[$i]
                    ? null
                    : ($request->batas_jurnal_menit[$i] ?: null),
            ];

            if ($jadwal) {
                $jadwal->update($data);
            } else {
                Jadwal::create($data);
            }
        }

        return redirect()
            ->route('admin.jadwals.index')
            ->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()
            ->route('admin.jadwals.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new JadwalExport, 'jadwal-pelajaran.xlsx');
    }
}