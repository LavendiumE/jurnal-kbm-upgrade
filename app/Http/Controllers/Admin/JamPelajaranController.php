<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class JamPelajaranController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return view('admin.settings.jam-kbm', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([

            'jam1_mulai' => 'required',
            'jam1_selesai' => 'required',

            'jam2_mulai' => 'required',
            'jam2_selesai' => 'required',

            'jam3_mulai' => 'required',
            'jam3_selesai' => 'required',

            'jam4_mulai' => 'required',
            'jam4_selesai' => 'required',

            'jam5_mulai' => 'required',
            'jam5_selesai' => 'required',

            'jam6_mulai' => 'required',
            'jam6_selesai' => 'required',

            'jam7_mulai' => 'required',
            'jam7_selesai' => 'required',

            'jam8_mulai' => 'required',
            'jam8_selesai' => 'required',

            'jam9_mulai' => 'required',
            'jam9_selesai' => 'required',

            'jam10_mulai' => 'required',
            'jam10_selesai' => 'required',

        ]);

        $setting = Setting::first();

        $setting->update($request->only([
            'jam1_mulai','jam1_selesai',
            'jam2_mulai','jam2_selesai',
            'jam3_mulai','jam3_selesai',
            'jam4_mulai','jam4_selesai',
            'jam5_mulai','jam5_selesai',
            'jam6_mulai','jam6_selesai',
            'jam7_mulai','jam7_selesai',
            'jam8_mulai','jam8_selesai',
            'jam9_mulai','jam9_selesai',
            'jam10_mulai','jam10_selesai',
        ]));

        return redirect()
            ->route('admin.jam-kbm.index')
            ->with('success', 'Jam KBM berhasil diperbarui.');
    }
}