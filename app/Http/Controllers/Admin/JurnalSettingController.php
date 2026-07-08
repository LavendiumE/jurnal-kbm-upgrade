<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class JurnalSettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return view('admin.settings.jurnal', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'batas_jurnal_menit' => 'required|integer|min:0|max:240',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        $setting->batas_jurnal_menit = $request->toleransi_jurnal;

        $setting->save();

        return back()->with(
            'success',
            'Pengaturan jurnal berhasil diperbarui.'
        );
    }
}