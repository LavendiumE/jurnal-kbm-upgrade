<?php

namespace App\Http\Controllers;

use App\Models\SiswaIzinKeluar;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaIzinKeluarExport;
use Illuminate\Support\Facades\Storage;
use Exception;

class SiswaIzinKeluarController extends Controller
{
    public function index()
    {
        $data = SiswaIzinKeluar::with('kelas')
            ->latest()
            ->paginate(10);

        return view('piket.perizinan.izin_keluar.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::all();

        return view('piket.perizinan.izin_keluar.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string',
            'kelas_id' => 'required',
            'keperluan' => 'nullable|string',
            'jam_izin' => 'required',
            'jam_kembali' => 'nullable',
            'paraf_guru' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,mp4,mov,avi,mkv|max:20480',
        ]);

        if ($request->hasFile('paraf_guru')) {

            $file = $request->file('paraf_guru');

            if (str_starts_with($file->getMimeType(), 'image/')) {

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

                $newWidth = min($width, 1280);
                $newHeight = intval($height * ($newWidth / $width));

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

                $folder = 'paraf-guru/' . now()->format('Y-m');
                $filename = uniqid('paraf_') . '.jpg';

                ob_start();
                imagejpeg($canvas, null, 75);
                $imageData = ob_get_clean();

                Storage::disk('public')->put(
                    $folder.'/'.$filename,
                    $imageData
                );

                imagedestroy($source);
                imagedestroy($canvas);

                $validated['paraf_guru'] = $folder.'/'.$filename;

            } else {

                // PDF dll
                $validated['paraf_guru'] = $file->store('paraf-guru', 'public');

            }
        }

        $kelas = Kelas::findOrFail($request->kelas_id);

        $validated['kelas'] = $kelas->nama;
        $validated['user_id'] = auth()->id();

        SiswaIzinKeluar::create($validated);

        return redirect()
            ->route('piket.perizinan.keluar.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = SiswaIzinKeluar::findOrFail($id);
        $kelas = Kelas::all();

        return view('piket.perizinan.izin_keluar.edit', compact('data', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $data = SiswaIzinKeluar::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string',
            'kelas_id' => 'required',
            'keperluan' => 'nullable|string',
            'jam_izin' => 'required',
            'jam_kembali' => 'nullable',
            'paraf_guru' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,mp4,mov,avi,mkv|max:20480',
        ]);

        if ($request->hasFile('paraf_guru')) {

            if ($data->paraf_guru) {
                Storage::disk('public')->delete($data->paraf_guru);
            }

            $file = $request->file('paraf_guru');

            if (str_starts_with($file->getMimeType(), 'image/')) {

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

                $newWidth = min($width, 1280);
                $newHeight = intval($height * ($newWidth / $width));

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

                $folder = 'paraf-guru/' . now()->format('Y-m');
                $filename = uniqid('paraf_') . '.jpg';

                ob_start();
                imagejpeg($canvas, null, 75);
                $imageData = ob_get_clean();

                Storage::disk('public')->put(
                    $folder.'/'.$filename,
                    $imageData
                );

                imagedestroy($source);
                imagedestroy($canvas);

                $validated['paraf_guru'] = $folder.'/'.$filename;

            } else {

                $validated['paraf_guru'] = $file->store('paraf-guru', 'public');

            }
        }

        $kelas = Kelas::findOrFail($request->kelas_id);

        $validated['kelas'] = $kelas->nama;

        $data->update($validated);

        return redirect()
            ->route('piket.perizinan.keluar.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = SiswaIzinKeluar::findOrFail($id);

        if ($data->paraf_guru) {
            Storage::disk('public')->delete($data->paraf_guru);
        }

        $data->delete();

        return redirect()
            ->route('piket.perizinan.keluar.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(
            new SiswaIzinKeluarExport,
            'izin-keluar.xlsx'
        );
    }
}