<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JamKbm;

class JamPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $hari = $request->get('hari', 'Senin');

        $jamPelajaran = JamKbm::where('hari', $hari)
            ->orderBy('jam_ke')
            ->get();

        $hariList = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat'
        ];

        return view(
            'admin.settings.jam-kbm',
            compact(
                'jamPelajaran',
                'hari',
                'hariList'
            )
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_ke.*' => 'required|integer',
            'jam_mulai.*' => 'required',
            'jam_selesai.*' => 'required',
        ]);

        foreach ($request->jam_ke as $index => $jamKe) {

            JamKbm::where('hari', $request->hari)
                ->where('jam_ke', $jamKe)
                ->update([

                    'jam_mulai' => $request->jam_mulai[$index],

                    'jam_selesai' => $request->jam_selesai[$index],

                ]);

        }

        return redirect()
            ->route(
                'admin.jam-kbm.index',
                ['hari' => $request->hari]
            )
            ->with(
                'success',
                'Jam KBM berhasil diperbarui.'
            );
    }
}