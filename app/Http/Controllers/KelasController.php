<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{

    public function index()
    {
        $data = Kelas::with('jurusan')->latest()->get();
        $jurusans = \App\Models\Jurusan::all();

        return view('admin.kelas.index', compact('data', 'jurusans'));
    }



    public function store(Request $request)
    {
        Kelas::create([
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return back();
    }

    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return back();
    }
}
