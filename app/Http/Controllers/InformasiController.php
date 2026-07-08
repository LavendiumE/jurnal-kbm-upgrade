<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required|string|max:1000',
        ]);

        Informasi::create([
            'isi' => $request->isi,
        ]);

        return back()->with(
            'success',
            'Informasi berhasil ditambahkan.'
        );
    }

    public function destroy($id)
    {
        Informasi::findOrFail($id)->delete();

        return back()->with('success', 'Informasi berhasil dihapus');
    }
}