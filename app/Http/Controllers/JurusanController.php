<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $data = Jurusan::latest()->get();
        return view('admin.jurusans.index', compact('data'));
    }

    public function store(Request $request)
    {
        Jurusan::create([
            'nama' => $request->nama
        ]);

        return back();
    }

    public function destroy($id)
    {
        Jurusan::findOrFail($id)->delete();
        return back();
    }
}
