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

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with(['guru', 'kelas', 'mapel', 'ruangan'])
            ->latest()
            ->paginate(10);

        return view('admin.jadwals.index', compact('jadwals'));
    }

    public function create()
    {
        return view('admin.jadwals.create', [
            'gurus' => Guru::all(),
            'kelas' => Kelas::all(),
            'mapels' => Mapel::all(),
            'ruangans' => Ruangan::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $jam_pelajaran = [
            1 => ['07:00', '07:45'],
            2 => ['07:45', '08:30'],
            3 => ['08:30', '09:15'],
            4 => ['09:30', '10:15'],
            5 => ['10:15', '11:00'],
            6 => ['11:00', '11:45'],
            7 => ['12:30', '13:15'],
            8 => ['13:15', '14:00'],
            9 => ['14:00', '14:45'],
            10 => ['14:45', '15:30'],
        ];

        foreach ($request->jam_ke as $i => $jam) {

            if (
                empty($request->mapel_id[$i]) ||
                empty($request->guru_id[$i]) ||
                empty($request->ruangan_id[$i])
            ) {
                continue;
            }

            Jadwal::create([
                'hari' => $request->hari,
                'kelas_id' => $request->kelas_id,
                'mapel_id' => $request->mapel_id[$i],
                'guru_id' => $request->guru_id[$i],
                'ruangan_id' => $request->ruangan_id[$i],
                'jam_ke' => $jam,
                'jam_mulai' => $jam_pelajaran[$jam][0],
                'jam_selesai' => $jam_pelajaran[$jam][1],
            ]);
        }

        return redirect()
            ->route('admin.jadwals.index')
            ->with('success', 'Jadwal berhasil disimpan');
    }

    public function edit(Jadwal $jadwal)
    {
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
            'gurus' => Guru::all(),
            'ruangans' => Ruangan::all(),
        ]);
    }

    public function update(Request $request, $group)
    {
        [$kelas_id, $hari] = explode('-', $group);

        Jadwal::where('kelas_id', $kelas_id)
            ->where('hari', $hari)
            ->delete();

        $jam_pelajaran = [
            1 => ['07:00', '07:45'],
            2 => ['07:45', '08:30'],
            3 => ['08:30', '09:15'],
            4 => ['09:30', '10:15'],
            5 => ['10:15', '11:00'],
            6 => ['11:00', '11:45'],
            7 => ['12:30', '13:15'],
            8 => ['13:15', '14:00'],
            9 => ['14:00', '14:45'],
            10 => ['14:45', '15:30'],
        ];

        foreach ($request->jam_ke as $i => $jam) {

            if (
                empty($request->mapel_id[$i]) ||
                empty($request->guru_id[$i]) ||
                empty($request->ruangan_id[$i])
            ) {
                continue;
            }

            Jadwal::create([
                'hari' => $request->hari,
                'kelas_id' => $kelas_id,
                'mapel_id' => $request->mapel_id[$i],
                'guru_id' => $request->guru_id[$i],
                'ruangan_id' => $request->ruangan_id[$i],
                'jam_ke' => $jam,
                'jam_mulai' => $jam_pelajaran[$jam][0],
                'jam_selesai' => $jam_pelajaran[$jam][1],
            ]);
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

