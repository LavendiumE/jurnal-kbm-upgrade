<?php

namespace App\Http\Controllers;

use App\Models\SiswaPulangAwal;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaPulangAwalExport;
use Illuminate\Support\Facades\Storage;
use Exception;

class SiswaPulangAwalController extends Controller
{
    public function index()
    {
        $data = SiswaPulangAwal::latest()->get();

        return view('piket.perizinan.pulang_awal.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::all();

        return view('piket.perizinan.pulang_awal.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string',
            'kelas' => 'required|string',
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'jam_izin' => 'required',
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

                $validated['paraf_guru'] = $file->store('paraf-guru', 'public');

            }
        }

        $validated['user_id'] = auth()->id();

        SiswaPulangAwal::create($validated);

        return redirect()->route('piket.perizinan.pulang.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $izin = SiswaPulangAwal::findOrFail($id);
        $kelas = Kelas::all();

        return view('piket.perizinan.pulang_awal.edit', compact('izin', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $izin = SiswaPulangAwal::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string',
            'kelas' => 'required|string',
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'jam_izin' => 'required',
            'paraf_guru' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,mp4,mov,avi,mkv|max:20480',
        ]);

        if ($request->hasFile('paraf_guru')) {

            if ($izin->paraf_guru) {
                Storage::disk('public')->delete($izin->paraf_guru);
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

        $izin->update($validated);

        return redirect()
            ->route('piket.perizinan.pulang.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $izin = SiswaPulangAwal::findOrFail($id);

        $izin->delete();

        return redirect()->route('piket.perizinan.pulang.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function export(Request $request)
    {
        return Excel::download(
            new SiswaPulangAwalExport(
                $request->tanggal_awal,
                $request->tanggal_akhir
            ),
            'izin-pulang-awal.xlsx'
        );
    }
}