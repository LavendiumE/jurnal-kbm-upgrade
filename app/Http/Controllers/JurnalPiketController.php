<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Exports\JurnalPiketExport;
use Maatwebsite\Excel\Facades\Excel;

class JurnalPiketController extends Controller
{
    public function index()
    {
        $data = Jurnal::with(['guru', 'kelas', 'jadwal.mapel', 'jadwal.ruangan'])
            ->where('tipe', 'piket')
            ->latest()
            ->paginate(10);

        return view('piket.jurnal.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::all();

        $jadwals = Jadwal::with([
            'guru',
            'mapel',
            'ruangan',
            'kelas'
        ])->get();

        return view('piket.jurnal.create', compact('kelas', 'jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'hari' => 'required',
            'jam_ke' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        $jadwal = Jadwal::where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where('jam_ke', $request->jam_ke)
            ->first();

        if (!$jadwal) {
            return back()->with('error', 'Jadwal tidak ditemukan');
        }

        $data = [
            'guru_id' => $jadwal->guru_id,
            'kelas_id' => $jadwal->kelas_id,
            'jadwal_id' => $jadwal->id,
            'tipe' => 'piket',
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('jurnal-piket', 'public');
        }

        Jurnal::create($data);

        return redirect()->route('piket.jurnal.index')
            ->with('success', 'Jurnal piket berhasil disimpan');
    }

    public function edit($id)
    {
        $data = Jurnal::findOrFail($id);
        $kelas = Kelas::all();

        return view('piket.jurnal.edit', compact('data', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $data = Jurnal::findOrFail($id);

        $jadwal = Jadwal::where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where('jam_ke', $request->jam_ke)
            ->first();

        if (!$jadwal) {
            return back()->with('error', 'Jadwal tidak ditemukan');
        }

        $update = [
            'guru_id' => $jadwal->guru_id,
            'kelas_id' => $jadwal->kelas_id,
            'jadwal_id' => $jadwal->id,
        ];

        if ($request->hasFile('foto')) {
            $update['foto'] = $request->file('foto')->store('jurnal-piket', 'public');
        }

        $data->update($update);

        return redirect()->route('piket.jurnal.index')
            ->with('success', 'Jurnal berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = Jurnal::findOrFail($id);

        if ($data->foto) {
            \Storage::disk('public')->delete($data->foto);
        }

        $data->delete();

        return redirect()->route('piket.jurnal.index')
            ->with('success', 'Jurnal berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new JurnalPiketExport, 'jurnal-guru-piket.xlsx');
    }
}