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
use App\Models\Siswa;
use App\Models\JurnalAbsensi;
use App\Exports\JurnalAbsensiExport;
use Illuminate\Support\Facades\DB;
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

        return view('guru.jurnals.index', compact(
            'jurnals',
            'informasi'
        ))->with('isKurikulum', false);
    }

    public function indexKurikulum()
    {
        if (!auth()->user()->hasRole('kurikulum')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $jurnals = Jurnal::with([
            'guru',
            'kelas',
            'jadwal.mapel'
        ])
        ->where('tipe', 'guru')
        ->latest()
        ->paginate(10);

        $informasi = Informasi::latest()->first();

        return view('guru.jurnals.index', compact(
            'jurnals',
            'informasi'
        ))->with('isKurikulum', true);
    }

    public function create()
    {
        $guru = Guru::where('user_id', auth()->id())->first();

        if (!$guru) {
            return back()->with('error', 'Akun guru belum terhubung ke data guru');
        }

        $setting = Setting::first();

       $defaultMenit = $setting->toleransi_jurnal ?? 30;

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

        $kelasIds = $jadwals->pluck('kelas_id')->unique();

        $siswas = Siswa::whereIn('kelas_id', $kelasIds)
            ->orderBy('nama')
            ->get();

        return view('guru.jurnals.create', compact('jadwals', 'siswas'));
    }

    public function store(Request $request)
    {
        // =========================
        // VALIDASI REQUEST
        // =========================
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'materi' => 'required',
            'kegiatan' => 'required',

            'foto' => 'nullable|image|max:10240',
            'file_izin_guru' => 'nullable|file|max:2048',

            // PJJ / DARING
            'is_daring' => 'nullable|boolean',
            'pjj_menggunakan' => 'nullable|array',
            'pjj_menggunakan.*' => 'in:wag,google_meet,zoom,google_classroom,lms,lainnya',
            'pjj_lainnya' => 'nullable|string|max:255',

            // ABSENSI
            'absensi' => 'required|array|min:1',
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alfa,pkl,dispensasi',
            'absensi.*.alasan' => 'nullable|string',
        ]);


        $guru = Guru::where('user_id', Auth::id())->first();

        if (!$guru) {
            return back()
                ->withInput()
                ->with('error', 'Akun guru belum terhubung ke data guru.');
        }


        $jadwal = Jadwal::findOrFail($request->jadwal_id);


        // =========================
        // VALIDASI GURU
        // =========================
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

        $defaultMenit = $setting->toleransi_jurnal ?? 30;

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
        // VALIDASI PJJ / DARING
        // =========================
        $isDaring = $request->boolean('is_daring');

        $pjjMenggunakan = $request->input('pjj_menggunakan', []);

        if (!$isDaring) {
            $pjjMenggunakan = [];
        }

        if ($isDaring && empty($pjjMenggunakan)) {
            return back()
                ->withInput()
                ->with('error', 'Silakan pilih minimal satu metode PJJ.');
        }

        $pjjLainnya = null;

        if ($isDaring && in_array('lainnya', $pjjMenggunakan)) {

            $pjjLainnya = trim($request->input('pjj_lainnya', ''));

            if ($pjjLainnya === '') {
                return back()
                    ->withInput()
                    ->with('error', 'Silakan isi metode PJJ lainnya.');
            }
        }


        // =========================
        // VALIDASI SISWA
        // =========================
        $siswaIds = array_keys($request->absensi);

        // Ambil semua siswa dari kelas jadwal
        $jumlahSiswaKelas = Siswa::where('kelas_id', $jadwal->kelas_id)
            ->count();

        // Pastikan jumlah siswa yang diabsen lengkap
        if (count($siswaIds) !== $jumlahSiswaKelas) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Absensi belum lengkap. Semua siswa dalam kelas harus diabsen.'
                );
        }


        // Pastikan semua siswa memang berasal dari kelas tersebut
        $jumlahSiswaValid = Siswa::whereIn('id', $siswaIds)
            ->where('kelas_id', $jadwal->kelas_id)
            ->count();

        if ($jumlahSiswaValid !== count($siswaIds)) {
            return back()
                ->withInput()
                ->with('error', 'Data absensi siswa tidak valid.');
        }


        // =========================
        // VALIDASI ALASAN
        // =========================
        foreach ($request->absensi as $siswaId => $absen) {

            if (
                $absen['status'] !== 'hadir' &&
                empty(trim($absen['alasan'] ?? ''))
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Alasan wajib diisi untuk siswa yang tidak hadir.'
                    );
            }
        }


        // =========================
        // DATA JURNAL
        // =========================
        $jurnalData = [
            'guru_id' => $guru->id,
            'kelas_id' => $jadwal->kelas_id,
            'jadwal_id' => $jadwal->id,
            'tipe' => 'guru',

            'materi' => $validated['materi'],
            'kegiatan' => $validated['kegiatan'],

            // PJJ / DARING
            'is_daring' => $isDaring,
            'pjj_menggunakan' => $isDaring ? $pjjMenggunakan : null,
            'pjj_lainnya' => $pjjLainnya,
        ];


        // =========================
        // FOTO
        // =========================
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


            $canvas = imagecreatetruecolor(
                $newWidth,
                $newHeight
            );


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

            imagejpeg(
                $canvas,
                null,
                75
            );

            $imageData = ob_get_clean();


            Storage::disk('public')->put(
                $folder . '/' . $filename,
                $imageData
            );


            imagedestroy($source);
            imagedestroy($canvas);


            $jurnalData['foto'] =
                $folder . '/' . $filename;
        }


        // =========================
        // SIMPAN JURNAL + ABSENSI
        // =========================
        DB::transaction(function () use ($jurnalData, $request) {

            $jurnal = Jurnal::create($jurnalData);


            foreach ($request->absensi as $siswaId => $absen) {

                JurnalAbsensi::create([
                    'jurnal_id' => $jurnal->id,
                    'siswa_id' => $siswaId,
                    'status' => $absen['status'],
                    'alasan' => $absen['alasan'] ?? null,
                ]);
            }

        });


        return redirect()
            ->route('guru.jurnals.index')
            ->with(
                'success',
                'Jurnal dan absensi berhasil ditambahkan'
            );
    }

    public function edit(Jurnal $jurnal)
    {
        abort_if($jurnal->tipe !== 'guru', 404);

        $jurnal->load([
            'kelas',
            'kelas.siswa',
            'jadwal.ruangan',
            'jadwal.mapel',
            'absensis.siswa',
        ]);

        return view('guru.jurnals.edit', compact('jurnal'));
    }

    public function update(Request $request, Jurnal $jurnal)
    {
        abort_if($jurnal->tipe !== 'guru', 404);

        // =========================
        // VALIDASI
        // =========================
        $validated = $request->validate([
            'materi' => 'required|string',
            'kegiatan' => 'nullable|string',

            // PJJ / DARING
            'is_daring' => 'nullable|boolean',
            'pjj_menggunakan' => 'nullable|array',
            'pjj_menggunakan.*' => 'in:wag,google_meet,zoom,google_classroom,lms,lainnya',
            'pjj_lainnya' => 'nullable|string|max:255',

            // ABSENSI
            'absensi' => 'required|array|min:1',
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alfa,pkl,dispensasi',
            'absensi.*.alasan' => 'nullable|string',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',

            'file_izin_guru' =>
                'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);


        // =========================
        // VALIDASI PJJ / DARING
        // =========================
        $isDaring = $request->boolean('is_daring');

        $pjjMenggunakan = $request->input('pjj_menggunakan', []);

        if (!$isDaring) {
            $pjjMenggunakan = [];
        }

        if ($isDaring && empty($pjjMenggunakan)) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Silakan pilih minimal satu metode PJJ.'
                );
        }


        $pjjLainnya = null;

        if (
            $isDaring &&
            in_array('lainnya', $pjjMenggunakan)
        ) {

            $pjjLainnya = trim(
                $request->input('pjj_lainnya', '')
            );

            if ($pjjLainnya === '') {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Silakan isi metode PJJ lainnya.'
                    );
            }
        }


        // =========================
        // VALIDASI SISWA
        // =========================
        $siswaIds = array_keys($request->absensi);

        $jumlahSiswaKelas = Siswa::where(
            'kelas_id',
            $jurnal->kelas_id
        )->count();

        if (count($siswaIds) !== $jumlahSiswaKelas) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Absensi belum lengkap. Semua siswa dalam kelas harus diabsen.'
                );
        }


        $jumlahSiswaValid = Siswa::whereIn(
            'id',
            $siswaIds
        )
            ->where(
                'kelas_id',
                $jurnal->kelas_id
            )
            ->count();

        if (
            $jumlahSiswaValid !== count($siswaIds)
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data absensi siswa tidak valid.'
                );
        }


        // =========================
        // VALIDASI ALASAN
        // =========================
        foreach (
            $request->absensi as $siswaId => $absen
        ) {

            if (
                $absen['status'] !== 'hadir' &&
                empty(
                    trim(
                        $absen['alasan'] ?? ''
                    )
                )
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Alasan wajib diisi untuk siswa yang tidak hadir.'
                    );
            }
        }


        // =========================
        // DATA JURNAL
        // =========================
        $jurnalData = [
            'materi' => $validated['materi'],
            'kegiatan' => $validated['kegiatan'],

            // PJJ / DARING
            'is_daring' => $isDaring,
            'pjj_menggunakan' => $isDaring
                ? $pjjMenggunakan
                : null,
            'pjj_lainnya' => $pjjLainnya,
        ];


        // =========================
        // FOTO
        // =========================
        if ($request->hasFile('foto')) {

            if ($jurnal->foto) {

                Storage::disk('public')
                    ->delete($jurnal->foto);
            }


            $file = $request->file('foto');

            $imageInfo = getimagesize(
                $file->getPathname()
            );

            $mime = $imageInfo['mime'];


            if ($mime === 'image/jpeg') {

                $source = imagecreatefromjpeg(
                    $file->getPathname()
                );

            } elseif ($mime === 'image/png') {

                $source = imagecreatefrompng(
                    $file->getPathname()
                );

            } elseif ($mime === 'image/webp') {

                $source = imagecreatefromwebp(
                    $file->getPathname()
                );

            } else {

                throw new Exception(
                    'Format gambar tidak didukung.'
                );
            }


            $width = imagesx($source);
            $height = imagesy($source);


            $newWidth = 1280;

            $newHeight = intval(
                $height * ($newWidth / $width)
            );


            if ($width < 1280) {

                $newWidth = $width;
                $newHeight = $height;
            }


            $canvas = imagecreatetruecolor(
                $newWidth,
                $newHeight
            );


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


            $folder =
                'jurnal-guru/' .
                now()->format('Y-m');

            $filename =
                uniqid('jurnal_') .
                '.jpg';


            ob_start();

            imagejpeg(
                $canvas,
                null,
                75
            );

            $imageData =
                ob_get_clean();


            Storage::disk('public')->put(
                $folder . '/' . $filename,
                $imageData
            );


            imagedestroy($source);
            imagedestroy($canvas);


            $jurnalData['foto'] =
                $folder . '/' . $filename;
        }


        // =========================
        // FILE IZIN GURU
        // =========================
        if ($request->hasFile('file_izin_guru')) {

            if ($jurnal->file_izin_guru) {

                Storage::disk('public')
                    ->delete(
                        $jurnal->file_izin_guru
                    );
            }


            $jurnalData['file_izin_guru'] =
                $request
                    ->file('file_izin_guru')
                    ->store(
                        'izin-guru',
                        'public'
                    );
        }


        // =========================
        // UPDATE JURNAL + ABSENSI
        // =========================
        DB::transaction(function () use (
            $jurnal,
            $jurnalData,
            $request
        ) {

            // Update jurnal utama
            $jurnal->update($jurnalData);


            // Hapus absensi lama
            $jurnal->absensis()->delete();


            // Simpan absensi terbaru
            foreach (
                $request->absensi as $siswaId => $absen
            ) {

                JurnalAbsensi::create([
                    'jurnal_id' => $jurnal->id,
                    'siswa_id' => $siswaId,
                    'status' => $absen['status'],
                    'alasan' => $absen['alasan'] ?? null,
                ]);
            }
        });


        return redirect()
            ->route('guru.jurnals.index')
            ->with(
                'success',
                'Jurnal dan absensi berhasil diupdate'
            );
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

    public function exportAll(Request $request)
    {
        if (!auth()->user()->hasRole('kurikulum')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return Excel::download(
            new AllJurnalsExport(
                $request->tanggal_awal,
                $request->tanggal_akhir
            ),
            'semua-jurnal-guru.xlsx'
        );
    }

    public function getSiswaByJadwal($jadwalId)
    {
        $jadwal = Jadwal::with('kelas')->findOrFail($jadwalId);

        $siswa = Siswa::where('kelas_id', $jadwal->kelas_id)
            ->orderBy('nama')
            ->get();

        return response()->json($siswa);
    }

    public function exportAbsensi(Jurnal $jurnal)
    {
        abort_if($jurnal->tipe !== 'guru', 404);

        $guru = Guru::where('user_id', Auth::id())->first();

        if (!$guru || $jurnal->guru_id !== $guru->id) {
            abort(403, 'Jurnal tidak valid.');
        }

        return Excel::download(
            new JurnalAbsensiExport($jurnal->id),
            'absensi-jurnal-' . $jurnal->id . '.xlsx'
        );
    }
}