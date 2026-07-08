<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return view('admin.settings.sekolah', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'teks_login'   => 'nullable|string|max:255',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        $setting->nama_sekolah = $request->nama_sekolah;
        $setting->teks_login   = $request->teks_login;
        
        
        // upload logo baru
        if ($request->hasFile('logo')) {

            // hapus logo lama
            if (
                $setting->logo &&
                Storage::disk('public')->exists($setting->logo)
            ) {
                Storage::disk('public')->delete($setting->logo);
            }

            $setting->logo = $request
                ->file('logo')
                ->store('settings', 'public');
        }

        $setting->save();

        return back()
            ->with('success', 'Pengaturan berhasil disimpan');
    }
}