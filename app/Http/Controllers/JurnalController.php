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
use App\Models\Setting;
use Carbon\Carbon;
use Exception;

class JurnalController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {

            $jurnals = Jurnal::where('tipe', 'guru')
                ->latest()
                ->paginate(10);

        } else {

            $guru = Guru::where('user_id', auth()->id())->first();

            if (!$guru) {
                return back()->with('error', 'Akun guru belum terhubung ke data guru');
            }

            $jurnals = Jurnal::where('guru_id', $guru->id)
                ->where('tipe', 'guru')
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

        $setting = Setting::first();

        $defaultMenit = $setting->batas_jurnal_menit ?? 30;

        // Konversi hari Carbon -> format database
        $hariMap = [
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ];

        $hariIni = $hariMap[now()->englishDayOfWeek] ?? null;

        $jadwals = Jadwal::with(['kelas', 'mapel', 'ruangan'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_ke')
            ->get()
            ->filter(function ($jadwal) use ($defaultMenit) {

                $menit = $jadwal->use_default_batas_jurnal
                    ? $defaultMenit
                    : $jadwal->batas_jurnal_menit;

                $deadline = Carbon::today()
                    ->setTimeFromTimeString($jadwal->jam_selesai)
                    ->addMinutes($menit);

                return now()->lte($deadline);
            });

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
            'foto' => 'nullable|image|max:10240',
            'file_izin_guru' => 'nullable|file|max:2048',
        ]);

        $guru = Guru::where('user_id', Auth::id())->first();
        $jadwal = Jadwal::findOrFail($request->jadwal_id);

        if ($jadwal->guru_id != $guru->id) {
            abort(403, 'Jadwal tidak valid.');
        }

        // =========================
        // VALIDASI HARI
        // =========================
        $hariMap = [
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ];

        $hariIni = $hariMap[now()->englishDayOfWeek] ?? null;

        if ($jadwal->hari !== $hariIni) {
            return back()
                ->withInput()
                ->with('error', 'Jurnal hanya dapat diisi sesuai jadwal pada hari ini.');
        }

        // =========================
        // VALIDASI BATAS WAKTU
        // =========================
        $setting = Setting::first();

        $defaultMenit = $setting->batas_jurnal_menit ?? 30;

        $menit = $jadwal->use_default_batas_jurnal
            ? $defaultMenit
            : $jadwal->batas_jurnal_menit;

        $deadline = now()->copy()
            ->setTimeFromTimeString($jadwal->jam_selesai)
            ->addMinutes($menit);

        if (now()->gt($deadline)) {
            return back()
                ->withInput()
                ->with('error', 'Batas waktu upload jurnal untuk jadwal ini sudah berakhir.');
        }

        // =========================
        // SIMPAN JURNAL
        // =========================
        $validated['guru_id'] = $guru->id;
        $validated['kelas_id'] = $jadwal->kelas_id;
        $validated['jadwal_id'] = $jadwal->id;
        $validated['tipe'] = 'guru';

        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $imageInfo = getimagesize($file->getPathname());
            $mime = $imageInfo['mime'];

            if ($mime === 'image/jpeg') {
                $source = imagecreatefromjpeg($file->getPathname());

            } elseif ($mime === 'image/png') {
                $source = imagecreatefrompng($file->getPathname());

            } elseif ($mime === 'image/webp') {
                $source = imagecreatefromwebp($file->getPathname());

            } else {
                throw new Exception('Format gambar tidak didukung.');
            }

            $width = imagesx($source);
            $height = imagesy($source);

            $newWidth = 1280;
            $newHeight = intval($height * ($newWidth / $width));

            if ($width < 1280) {
                $newWidth = $width;
                $newHeight = $height;
            }

            $canvas = imagecreatetruecolor($newWidth, $newHeight);

            imagecopyresampled(
                $canvas,
                $source,
                0,
                0,
                0,
                0,
                $newWidth,
                $newHeight,
                $width,
                $height
            );

            $folder = 'jurnal-guru/' . now()->format('Y-m');
            $filename = uniqid('jurnal_') . '.jpg';

            ob_start();
            imagejpeg($canvas, null, 75);
            $imageData = ob_get_clean();

            Storage::disk('public')->put(
                $folder . '/' . $filename,
                $imageData
            );

            imagedestroy($source);
            imagedestroy($canvas);

            $validated['foto'] = $folder . '/' . $filename;
        }

        Jurnal::create($validated);

        return redirect()
            ->route('guru.jurnals.index')
            ->with('success', 'Jurnal berhasil ditambahkan');
    }

    public function edit(Jurnal $jurnal)
    {
        abort_if($jurnal->tipe !== 'guru', 404);

        return view('guru.jurnals.edit', compact('jurnal'));
    }

    public function update(Request $request, Jurnal $jurnal)
    {
        abort_if($jurnal->tipe !== 'guru', 404);

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

            $file = $request->file('foto');

            $imageInfo = getimagesize($file->getPathname());
            $mime = $imageInfo['mime'];

            if ($mime === 'image/jpeg') {
                $source = imagecreatefromjpeg($file->getPathname());

            } elseif ($mime === 'image/png') {
                $source = imagecreatefrompng($file->getPathname());

            } elseif ($mime === 'image/webp') {
                $source = imagecreatefromwebp($file->getPathname());

            } else {
                throw new Exception('Format gambar tidak didukung.');
            }

            $width = imagesx($source);
            $height = imagesy($source);

            $newWidth = 1280;
            $newHeight = intval($height * ($newWidth / $width));

            if ($width < 1280) {
                $newWidth = $width;
                $newHeight = $height;
            }

            $canvas = imagecreatetruecolor($newWidth, $newHeight);

            imagecopyresampled(
                $canvas,
                $source,
                0,
                0,
                0,
                0,
                $newWidth,
                $newHeight,
                $width,
                $height
            );

            $folder = 'jurnal-guru/' . now()->format('Y-m');
            $filename = uniqid('jurnal_') . '.jpg';

            ob_start();
            imagejpeg($canvas, null, 75);
            $imageData = ob_get_clean();

            Storage::disk('public')->put(
                $folder . '/' . $filename,
                $imageData
            );

            imagedestroy($source);
            imagedestroy($canvas);

            $validated['foto'] = $folder . '/' . $filename;
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
        abort_if($jurnal->tipe !== 'guru', 404);
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