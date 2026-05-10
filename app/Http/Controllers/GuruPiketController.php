<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perizinan;

class PiketController extends Controller
{

    public function dashboard()
    {

        $perizinans = Perizinan::latest()->take(10)->get();

        return view('piket.dashboard', compact('perizinans'));

        $hari = strtolower(now()->locale('id')->translatedFormat('l'));

        $jadwalsHariIni = Jadwal::with(['kelas','guru','mapel','ruangan'])
            ->where('hari', $hari)
            ->orderBy('jam_ke')
            ->get();

        return view('piket.dashboard', compact('jadwalsHariIni'));

    }

}