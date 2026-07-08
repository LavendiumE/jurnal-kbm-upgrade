<?php

namespace App\Http\Controllers;

use App\Models\SiswaTerlambat;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Exports\SiswaTerlambatExport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaTerlambatController extends Controller
{
    public function index()
    {
        $data = SiswaTerlambat::with([
            'kelas',
            'guruPembina'
        ])->latest()->get();

        return view('piket.perizinan.siswa_terlambat.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $gurus = Guru::whereHas('user', function ($query) {
                    $query->where('is_active', true);
                })->orderBy('nama')->get();

        return view('piket.perizinan.siswa_terlambat.create', compact('kelas', 'gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string',
            'nis' => 'required|string',
            'kelas_id' => 'required',
            'jam_terlambat' => 'required',
            'cuaca' => 'nullable|string',
            'alasan' => 'nullable|string',
            'guru_pembina_id' => 'nullable',
            'pembinaan' => 'nullable|string',
            'paraf_guru' => 'nullable|file',
        ]);

        if ($request->hasFile('paraf_guru')) {
            $validated['paraf_guru'] = $request->file('paraf_guru')->store('paraf-terlambat', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['tanggal'] = now()->toDateString();

        SiswaTerlambat::create($validated);

        return redirect()->route('piket.perizinan.terlambat.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = SiswaTerlambat::findOrFail($id);
        $kelas = Kelas::all();
        $gurus = Guru::whereHas('user', function ($query) {
                    $query->where('is_active', true);
                })->orderBy('nama')->get();

        return view('piket.perizinan.siswa_terlambat.edit', compact('data', 'kelas', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $data = SiswaTerlambat::findOrFail($id);

        $validated = $request->validate([
            'nama_siswa' => 'required|string',
            'nis' => 'required|string',
            'kelas_id' => 'required',
            'jam_terlambat' => 'required',
            'cuaca' => 'nullable|string',
            'alasan' => 'nullable|string',
            'guru_pembina_id' => 'nullable',
            'pembinaan' => 'nullable|string',
            'paraf_guru' => 'nullable|file',
        ]);

        if ($request->hasFile('paraf_guru')) {
            $validated['paraf_guru'] = $request->file('paraf_guru')->store('paraf-terlambat', 'public');
        }

        $validated['tanggal'] = now()->toDateString();

        $data->update($validated);

        return redirect()->route('piket.perizinan.terlambat.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = SiswaTerlambat::findOrFail($id);

        $data->delete();

        return redirect()->route('piket.perizinan.terlambat.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new SiswaTerlambatExport, 'siswa-terlambat.xlsx');
    }
}