<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar kelas
     */
    public function index()
    {
        $kelas = Kelas::withCount('siswa')
            ->orderBy('nama')
            ->get();

        return view('admin.siswa.index', compact('kelas'));
    }


    /**
     * Menampilkan siswa berdasarkan kelas
     */
    public function kelas($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);

        $siswa = Siswa::where('kelas_id', $kelas_id)
            ->orderBy('nama')
            ->get();

        return view('admin.siswa.kelas', compact('kelas', 'siswa'));
    }


    /**
     * Form tambah siswa
     */
    public function create($kelas_id)
    {
        $kelas = Kelas::orderBy('nama')->get();

        $kelasTerpilih = Kelas::findOrFail($kelas_id);

        return view(
            'admin.siswa.create',
            compact('kelas', 'kelasTerpilih')
        );
    }


    /**
     * Simpan siswa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:50|unique:siswas,nis',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp' => 'nullable|string|max:20',
        ]);

        Siswa::create($validated);

        return redirect()
            ->route('admin.siswa.kelas', $validated['kelas_id'])
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }


    /**
     * Form edit siswa
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        $kelas = Kelas::orderBy('nama')->get();

        return view(
            'admin.siswa.edit',
            compact('siswa', 'kelas')
        );
    }


    /**
     * Update siswa
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|max:50|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $siswa->update($validated);

        return redirect()
            ->route('admin.siswa.kelas', $validated['kelas_id'])
            ->with('success', 'Data siswa berhasil diupdate.');
    }


    /**
     * Hapus siswa
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        $kelas_id = $siswa->kelas_id;

        $siswa->delete();

        return redirect()
            ->route('admin.siswa.kelas', $kelas_id)
            ->with('success', 'Data siswa berhasil dihapus.');
    }


    /**
     * Import siswa dari Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        Excel::import(
            new SiswaImport,
            $request->file('file')
        );

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diimport.');
    }
}