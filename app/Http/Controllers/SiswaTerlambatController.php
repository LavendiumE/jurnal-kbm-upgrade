<?php

namespace App\Http\Controllers;

use App\Models\SiswaTerlambat;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Exports\SiswaTerlambatExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;
use Exception;

class SiswaTerlambatController extends Controller
{
    public function index()
    {
        $data = SiswaTerlambat::with([
            'kelas',
            'guruPembina'
        ])->latest()->get();

        return view('piket.perizinan.siswa_terlambat.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama')->get();

        $siswa = Siswa::orderBy('nama')->get();

        $gurus = Guru::whereHas('user', function ($query) {
                    $query->where('is_active', true);
                })
                ->orderBy('nama')
                ->get();

        return view(
            'piket.perizinan.siswa_terlambat.create',
            compact('kelas', 'siswa', 'gurus')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string',
            'nis' => 'required|string',
            'kelas_id' => 'required',
            'tanggal' => 'required|date',
            'jam_terlambat' => 'required',
            'cuaca' => 'nullable|string',
            'alasan' => 'nullable|string',
            'guru_pembina_id' => 'nullable',
            'pembinaan' => 'nullable|string',
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

                $folder = 'paraf-terlambat/' . now()->format('Y-m');
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

                $validated['paraf_guru'] = $file->store('paraf-terlambat', 'public');

            }
        }

        $validated['user_id'] = auth()->id();

        SiswaTerlambat::create($validated);

        return redirect()->route('piket.perizinan.terlambat.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = SiswaTerlambat::findOrFail($id);

        $kelas = Kelas::orderBy('nama')->get();

        $siswa = Siswa::orderBy('nama')->get();

        $gurus = Guru::whereHas('user', function ($query) {
                    $query->where('is_active', true);
                })
                ->orderBy('nama')
                ->get();

        return view(
            'piket.perizinan.siswa_terlambat.edit',
            compact('data', 'kelas', 'siswa', 'gurus')
        );
    }

    public function update(Request $request, $id)
    {
        $data = SiswaTerlambat::findOrFail($id);

        $validated = $request->validate([
            'nama_siswa' => 'required|string',
            'nis' => 'required|string',
            'kelas_id' => 'required',
            'tanggal' => 'required|date',
            'jam_terlambat' => 'required',
            'cuaca' => 'nullable|string',
            'alasan' => 'nullable|string',
            'guru_pembina_id' => 'nullable',
            'pembinaan' => 'nullable|string',
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

                $folder = 'paraf-terlambat/' . now()->format('Y-m');
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

                $validated['paraf_guru'] = $file->store('paraf-terlambat', 'public');

            }
        }

        $data->update($validated);

        return redirect()->route('piket.perizinan.terlambat.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = SiswaTerlambat::findOrFail($id);

        if ($data->paraf_guru) {
            Storage::disk('public')->delete($data->paraf_guru);
        }

        $data->delete();

        return redirect()->route('piket.perizinan.terlambat.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function export(Request $request)
    {
        return Excel::download(
            new SiswaTerlambatExport(
                $request->tanggal_awal,
                $request->tanggal_akhir
            ),
            'siswa-terlambat.xlsx'
        );
    }
}