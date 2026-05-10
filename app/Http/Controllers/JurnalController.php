<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Guru;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllJurnalsExport;
use App\Exports\MyJurnalsExport;
use App\Models\Informasi;

class JurnalController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $jurnals = Jurnal::latest()->paginate(10);
        } else {
            $guru = Guru::where('user_id', auth()->id())->first();

            if (!$guru) {
                return back()->with('error', 'Akun guru belum terhubung ke data guru');
            }

            $jurnals = Jurnal::where('guru_id', $guru->id)
                ->latest()
                ->paginate(10);
        }

        $informasi = Informasi::latest()->first();

        return view('guru.jurnals.index', compact('jurnals', 'informasi'));
    }

    public function create()
    {
        $guru = Guru::where('user_id', auth()->id())->first();

        if (!$guru) {
            return back()->with('error', 'Akun guru belum terhubung ke data guru');
        }

        $jadwals = Jadwal::with(['kelas', 'mapel', 'ruangan'])
            ->where('guru_id', $guru->id)
            ->orderBy('hari')
            ->orderBy('jam_ke')
            ->get();

        return view('guru.jurnals.create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required',
            'materi' => 'required',
            'kegiatan' => 'required',
            'hadir' => 'required|integer',
            'izin' => 'nullable|string',
            'sakit' => 'nullable|string',
            'alfa' => 'nullable|string',
            'pkl' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'file_izin_guru' => 'nullable|file|max:2048',
        ]);

        $guru = Guru::where('user_id', Auth::id())->first();
        $jadwal = Jadwal::findOrFail($request->jadwal_id);

        $validated['guru_id'] = $guru->id;
        $validated['kelas_id'] = $jadwal->kelas_id;
        $validated['jadwal_id'] = $jadwal->id;
        $validated['tipe'] = 'guru';

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('jurnal-guru', 'public');
        }

        Jurnal::create($validated);

        return redirect()
            ->route('guru.jurnals.index')
            ->with('success', 'Jurnal berhasil ditambahkan');
    }

    public function edit(Jurnal $jurnal)
    {
        return view('guru.jurnals.edit', compact('jurnal'));
    }

    public function update(Request $request, Jurnal $jurnal)
    {
        $validated = $request->validate([
            'materi' => 'required|string',
            'kegiatan' => 'nullable|string',
            'hadir' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'sakit' => 'nullable|integer|min:0',
            'alfa' => 'nullable|integer|min:0',
            'pkl' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'file_izin_guru' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('foto')) {
            if ($jurnal->foto) {
                Storage::disk('public')->delete($jurnal->foto);
            }

            $validated['foto'] = $request->file('foto')->store('jurnal-guru', 'public');
        }

        if ($request->hasFile('file_izin_guru')) {
            if ($jurnal->file_izin_guru) {
                Storage::disk('public')->delete($jurnal->file_izin_guru);
            }

            $validated['file_izin_guru'] = $request->file('file_izin_guru')->store('izin-guru', 'public');
        }

        $jurnal->update($validated);

        return redirect()
            ->route('guru.jurnals.index')
            ->with('success', 'Jurnal berhasil diupdate');
    }

    public function destroy(Jurnal $jurnal)
    {
        // Hapus file foto kalau ada
        if ($jurnal->foto) {
            Storage::disk('public')->delete($jurnal->foto);
        }

        // Hapus file izin guru kalau ada
        if ($jurnal->file_izin_guru) {
            Storage::disk('public')->delete($jurnal->file_izin_guru);
        }

        // Hapus jurnal
        $jurnal->delete();

        return redirect()
            ->route('guru.jurnals.index')
            ->with('success', 'Jurnal berhasil dihapus');
    }

    public function exportMine(Request $request)
    {
        $guru = Guru::where('user_id', auth()->id())->first();

        if (!$guru) {
            return back()->with('error', 'Akun guru belum terhubung ke data guru');
        }

        return Excel::download(
            new MyJurnalsExport(
                $guru->id,
                $request->tanggal_awal,
                $request->tanggal_akhir
            ),
            'jurnal-saya.xlsx'
        );
    }
}