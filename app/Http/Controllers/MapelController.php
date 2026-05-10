<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $data = Mapel::latest()->get();
        return view('admin.mapels.index', compact('data'));
    }

    public function store(Request $request)
    {
        Mapel::create([
            'nama' => $request->nama
        ]);

        return back();
    }

    public function destroy($id)
    {
        Mapel::findOrFail($id)->delete();
        return back();
    }
}
