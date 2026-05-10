@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <h2 class="text-2xl font-semibold mb-6">
        Tambah Jurnal KBM
    </h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('guru.jurnals.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6 space-y-5">

        @csrf

        {{-- PILIH JADWAL --}}
        <div>
            <label class="block text-sm font-medium mb-2">
                Pilih Jadwal Mengajar
            </label>

            <select name="jadwal_id"
                    id="jadwalSelect"
                    class="w-full border rounded px-3 py-2"
                    required>

                <option value="">-- Pilih Jadwal --</option>

                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id }}"
                        data-kelas="{{ $jadwal->kelas->nama }}"
                        data-mapel="{{ $jadwal->mapel->nama }}"
                        data-ruangan="{{ $jadwal->ruangan->nama ?? '-' }}"
                        data-jam="{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}">
                        {{ ucfirst($jadwal->hari) }} | Jam {{ $jadwal->jam_ke }} | {{ $jadwal->kelas->nama }} | {{ $jadwal->mapel->nama }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- TANGGAL --}}
        <div>
            <label class="block text-sm font-medium">Tanggal KBM</label>
            <input type="date"
                   name="tanggal_kbm"
                   value="{{ now()->format('Y-m-d') }}"
                   class="mt-1 w-full border rounded px-3 py-2"
                   required>
        </div>

        {{-- KELAS --}}
        <div>
            <label class="block text-sm font-medium">Kelas</label>
            <input type="text"
                   id="kelasField"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- RUANGAN --}}
        <div>
            <label class="block text-sm font-medium">Ruangan</label>
            <input type="text"
                   id="ruanganField"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- MAPEL --}}
        <div>
            <label class="block text-sm font-medium">Mata Pelajaran</label>
            <input type="text"
                   id="mapelField"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- JAM --}}
        <div>
            <label class="block text-sm font-medium">Jam Pelajaran</label>
            <input type="text"
                   id="jamField"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- MATERI --}}
        <div>
            <label class="block text-sm font-medium">Materi</label>
            <textarea name="materi"
                      rows="3"
                      class="mt-1 w-full border rounded px-3 py-2"
                      required>{{ old('materi') }}</textarea>
        </div>

        {{-- KEGIATAN --}}
        <div>
            <label class="block text-sm font-medium">Kegiatan</label>
            <textarea name="kegiatan"
                      rows="2"
                      class="mt-1 w-full border rounded px-3 py-2">{{ old('kegiatan') }}</textarea>
        </div>

        {{-- ABSENSI --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <div>
                <label class="block text-sm font-medium">Hadir</label>
                <input type="number"
                       name="hadir"
                       min="0"
                       value="{{ old('hadir', 0) }}"
                       class="mt-1 w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Izin</label>
                <textarea name="izin"
                          rows="3"
                          class="mt-1 w-full border rounded px-3 py-2">{{ old('izin') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Sakit</label>
                <textarea name="sakit"
                          rows="3"
                          class="mt-1 w-full border rounded px-3 py-2">{{ old('sakit') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Alfa</label>
                <textarea name="alfa"
                          rows="3"
                          class="mt-1 w-full border rounded px-3 py-2">{{ old('alfa') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">PKL</label>
                <textarea name="pkl"
                        rows="3"
                        class="mt-1 w-full border rounded px-3 py-2">{{ old('pkl') }}</textarea>
            </div>

        </div>

        {{-- FOTO --}}
        <div>
            <label class="block text-sm font-medium">Dokumentasi Kegiatan</label>
            <input type="file"
                   name="foto"
                   accept="image/*"
                   class="mt-1 w-full border rounded px-3 py-2">
        </div>

        {{-- FILE IZIN --}}
        <div>
            <label class="block text-sm font-medium">Upload Surat Izin Guru (Opsional)</label>
            <input type="file"
                   name="file_izin_guru"
                   class="mt-1 w-full border rounded px-3 py-2">
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-4">

            <a href="{{ route('guru.jurnals.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Simpan
            </button>

        </div>

    </form>

</div>


<script>
document.getElementById('jadwalSelect').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];

    document.getElementById('kelasField').value = selected.dataset.kelas || '';
    document.getElementById('mapelField').value = selected.dataset.mapel || '';
    document.getElementById('ruanganField').value = selected.dataset.ruangan || '';
    document.getElementById('jamField').value = selected.dataset.jam || '';
});
</script>

@endsection