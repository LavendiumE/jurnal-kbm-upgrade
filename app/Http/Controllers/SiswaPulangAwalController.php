<?php

namespace App\Http\Controllers;

use App\Models\SiswaPulangAwal;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaPulangAwalExport;

class SiswaPulangAwalController extends Controller
{
    public function index()
    {
        $data = SiswaPulangAwal::latest()->get();

        return view('piket.perizinan.pulang_awal.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::all();

        return view('piket.perizinan.pulang_awal.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string',
            'kelas' => 'required|string',
            'keperluan' => 'required|string',
            'jam_izin' => 'required',
            'paraf_guru' => 'nullable|file',
        ]);

        if ($request->hasFile('paraf_guru')) {
            $validated['paraf_guru'] = $request->file('paraf_guru')->store('paraf-guru', 'public');
        }

        $validated['user_id'] = auth()->id();

        $validated['tanggal'] = now()->toDateString();

        SiswaPulangAwal::create($validated);

        return redirect()->route('piket.perizinan.pulang.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $izin = SiswaPulangAwal::findOrFail($id);
        $kelas = Kelas::all();

        return view('piket.perizinan.pulang_awal.edit', compact('izin', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $izin = SiswaPulangAwal::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string',
            'kelas' => 'required|string',
            'keperluan' => 'required|string',
            'jam_izin' => 'required',
        ]);

        $validated['tanggal'] = now()->toDateString();

        $izin->update($validated);

        return redirect()->route('piket.perizinan.pulang.index')
            ->with('success', 'Data berhasil diupdate');

        if ($request->hasFile('paraf_guru')) {
            $validated['paraf_guru'] = $request->file('paraf_guru')->store('paraf-pulang-awal', 'public');
        }
    }

    public function destroy($id)
    {
        $izin = SiswaPulangAwal::findOrFail($id);

        $izin->delete();

        return redirect()->route('piket.perizinan.pulang.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new SiswaPulangAwalExport, 'izin-pulang-awal.xlsx');
    }
}