@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <h2 class="text-2xl font-semibold mb-6">
        Edit Jurnal KBM
    </h2>

    <form action="{{ route('guru.jurnals.update', $jurnal->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6 space-y-5">

        @csrf
        @method('PUT')

        {{-- TANGGAL --}}
        <div>
            <label class="block text-sm font-medium">Tanggal KBM</label>
            <input type="date"
                   value="{{ $jurnal->created_at->format('Y-m-d') }}"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- KELAS --}}
        <div>
            <label class="block text-sm font-medium">Kelas</label>
            <input type="text"
                   value="{{ $jurnal->kelas->nama ?? '-' }}"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- RUANGAN --}}
        <div>
            <label class="block text-sm font-medium">Ruangan</label>
            <input type="text"
                   value="{{ $jurnal->jadwal->ruangan->nama ?? '-' }}"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- MAPEL --}}
        <div>
            <label class="block text-sm font-medium">Mata Pelajaran</label>
            <input type="text"
                   value="{{ $jurnal->jadwal->mapel->nama ?? '-' }}"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- JAM --}}
        <div>
            <label class="block text-sm font-medium">Jam Pelajaran</label>
            <input type="text"
                   value="{{ $jurnal->jadwal->jam_mulai ?? '-' }} - {{ $jurnal->jadwal->jam_selesai ?? '-' }}"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- MATERI --}}
        <div>
            <label class="block text-sm font-medium">Materi</label>
            <textarea name="materi"
                      rows="3"
                      class="mt-1 w-full border rounded px-3 py-2"
                      required>{{ $jurnal->materi }}</textarea>
        </div>

        {{-- KEGIATAN --}}
        <div>
            <label class="block text-sm font-medium">Kegiatan</label>
            <textarea name="kegiatan"
                      rows="2"
                      class="mt-1 w-full border rounded px-3 py-2">{{ $jurnal->kegiatan }}</textarea>
        </div>

        {{-- ABSENSI --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <div>
                <label class="block text-sm font-medium">Hadir</label>
                <input type="number"
                       name="hadir"
                       value="{{ $jurnal->hadir }}"
                       class="mt-1 w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Izin</label>
                <textarea name="izin"
                          rows="3"
                          class="mt-1 w-full border rounded px-3 py-2">{{ $jurnal->izin }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Sakit</label>
                <textarea name="sakit"
                          rows="3"
                          class="mt-1 w-full border rounded px-3 py-2">{{ $jurnal->sakit }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Alfa</label>
                <textarea name="alfa"
                          rows="3"
                          class="mt-1 w-full border rounded px-3 py-2">{{ $jurnal->alfa }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">PKL</label>
                <textarea name="pkl"
                        rows="3"
                        class="mt-1 w-full border rounded px-3 py-2">{{ $jurnal->pkl }}</textarea>
            </div>

        </div>

        {{-- FOTO --}}
        <div>
            <label class="block text-sm font-medium mb-1">
                Dokumentasi Kegiatan
            </label>

            @if ($jurnal->foto)
                <img src="{{ asset('storage/'.$jurnal->foto) }}"
                     class="w-40 rounded mb-2 border">
            @endif

            <input type="file"
                   name="foto"
                   accept="image/*"
                   capture="environment"
                   class="mt-1 w-full border rounded px-3 py-2">
        </div>

        {{-- FILE IZIN --}}
        <div>
            <label class="block text-sm font-medium mb-1">
                Surat Izin Guru
            </label>

            @if($jurnal->file_izin_guru)
                <a href="{{ asset('storage/'.$jurnal->file_izin_guru) }}"
                   target="_blank"
                   class="text-blue-600 text-sm underline block mb-2">
                    Lihat file saat ini
                </a>
            @endif

            <input type="file"
                   name="file_izin_guru"
                   class="mt-1 w-full border rounded px-3 py-2">
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3">

            <a href="{{ route('guru.jurnals.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Update
            </button>

        </div>

    </form>

</div>

@endsection