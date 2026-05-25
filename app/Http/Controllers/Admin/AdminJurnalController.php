<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Exports\AllJurnalsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminJurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::with([
            'guru.user',
            'kelas',
            'jadwal.mapel'
        ])
        ->latest()
        ->paginate(10);

        return view(
            'admin.jurnals.index',
            compact('jurnals')
        );
    }

    public function export()
    {
        return Excel::download(
            new AllJurnalsExport(
                request('tanggal_awal'),
                request('tanggal_akhir')
            ),
            'all-jurnal.xlsx'
        );
    }
}