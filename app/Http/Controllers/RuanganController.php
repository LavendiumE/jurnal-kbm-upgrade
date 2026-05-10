<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $data = Ruangan::latest()->get();
        return view('admin.ruangans.index', compact('data'));
    }

    public function store(Request $request)
    {
        Ruangan::create([
            'nama' => $request->nama
        ]);

        return back();
    }

    public function destroy($id)
    {
        Ruangan::findOrFail($id)->delete();
        return back();
    }
}