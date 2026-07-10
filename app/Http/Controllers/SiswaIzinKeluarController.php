<?php

namespace App\Http\Controllers;

use App\Models\SiswaIzinKeluar;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaIzinKeluarExport;
use Illuminate\Support\Facades\Storage;

class SiswaIzinKeluarController extends Controller
{
    public function index()
    {
        $data = SiswaIzinKeluar::with('kelas')
            ->latest()
            ->paginate(10);

        return view('piket.perizinan.izin_keluar.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::all();

        return view('piket.perizinan.izin_keluar.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string',
            'kelas_id' => 'required',
            'keperluan' => 'nullable|string',
            'jam_izin' => 'required',
            'jam_kembali' => 'nullable',
            'paraf_guru' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('paraf_guru')) {
            $validated['paraf_guru'] = $request
                ->file('paraf_guru')
                ->store('paraf-guru', 'public');
        }

        $kelas = Kelas::findOrFail($request->kelas_id);

        $validated['kelas'] = $kelas->nama;
        $validated['user_id'] = auth()->id();

        SiswaIzinKeluar::create($validated);

        return redirect()
            ->route('piket.perizinan.keluar.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = SiswaIzinKeluar::findOrFail($id);
        $kelas = Kelas::all();

        return view('piket.perizinan.izin_keluar.edit', compact('data', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $data = SiswaIzinKeluar::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string',
            'kelas_id' => 'required',
            'keperluan' => 'nullable|string',
            'jam_izin' => 'required',
            'jam_kembali' => 'nullable',
            'paraf_guru' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('paraf_guru')) {

            if ($data->paraf_guru) {
                Storage::disk('public')->delete($data->paraf_guru);
            }

            $validated['paraf_guru'] = $request
                ->file('paraf_guru')
                ->store('paraf-izin-keluar', 'public');
        }

        $kelas = Kelas::findOrFail($request->kelas_id);

        $validated['kelas'] = $kelas->nama;

        $data->update($validated);

        return redirect()
            ->route('piket.perizinan.keluar.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = SiswaIzinKeluar::findOrFail($id);

        if ($data->paraf_guru) {
            Storage::disk('public')->delete($data->paraf_guru);
        }

        $data->delete();

        return redirect()
            ->route('piket.perizinan.keluar.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(
            new SiswaIzinKeluarExport,
            'izin-keluar.xlsx'
        );
    }
}