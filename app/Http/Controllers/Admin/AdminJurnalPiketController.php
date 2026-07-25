<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Exports\JurnalPiketExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminJurnalPiketController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::with([
            'guru',
            'kelas',
            'jadwal.mapel',
            'jadwal.ruangan'
        ])
        ->where('tipe', 'piket')
        ->latest()
        ->paginate(10);

        return view(
            'admin.jurnal-piket.index',
            compact('jurnals')
        );
    }

    public function export()
    {
        return Excel::download(
            new JurnalPiketExport,
            'jurnal-guru-piket.xlsx'
        );
    }
}