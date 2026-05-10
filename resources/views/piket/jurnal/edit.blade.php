@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">
            Edit Jurnal Guru Piket
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Perbarui data jurnal berdasarkan jadwal pelajaran
        </p>
    </div>

    <form action="{{ route('piket.jurnal.update', $data->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white border rounded-lg p-6 space-y-6">

            {{-- KELAS --}}
            <div>
                <label class="block text-sm font-medium mb-2">Kelas</label>
                <select name="kelas_id"
                        class="w-full border rounded px-3 py-2"
                        required>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ $data->kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- HARI --}}
            <div>
                <label class="block text-sm font-medium mb-2">Hari</label>
                <select name="hari"
                        class="w-full border rounded px-3 py-2"
                        required>
                    @foreach(['senin','selasa','rabu','kamis','jumat','sabtu'] as $hari)
                        <option value="{{ $hari }}"
                            {{ optional($data->jadwal)->hari == $hari ? 'selected' : '' }}>
                            {{ ucfirst($hari) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- JAM KE --}}
            <div>
                <label class="block text-sm font-medium mb-2">Jam Ke</label>
                <select name="jam_ke"
                        class="w-full border rounded px-3 py-2"
                        required>
                    @for($i=1; $i<=10; $i++)
                        <option value="{{ $i }}"
                            {{ optional($data->jadwal)->jam_ke == $i ? 'selected' : '' }}>
                            Jam ke-{{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- MAPEL --}}
            <p class="text-sm text-gray-500 mt-1">
                Data mapel, guru, dan ruangan akan menyesuaikan setelah jurnal diupdate.
            </p>
            <div>
                <label class="block text-sm font-medium mb-2">Mata Pelajaran</label>
                <input type="text"
                       value="{{ $data->jadwal->mapel->nama ?? '-' }}"
                       class="w-full border rounded px-3 py-2 bg-gray-100"
                       readonly>
            </div>

            {{-- GURU --}}
            <div>
                <label class="block text-sm font-medium mb-2">Guru Pengajar</label>
                <input type="text"
                       value="{{ $data->guru->nama ?? '-' }}"
                       class="w-full border rounded px-3 py-2 bg-gray-100"
                       readonly>
            </div>

            {{-- RUANGAN --}}
            <div>
                <label class="block text-sm font-medium mb-2">Ruangan</label>
                <input type="text"
                       value="{{ $data->jadwal->ruangan->nama ?? '-' }}"
                       class="w-full border rounded px-3 py-2 bg-gray-100"
                       readonly>
            </div>

            {{-- FOTO --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Upload Bukti Foto Baru
                </label>

                <input type="file"
                       name="foto"
                       class="w-full border rounded px-3 py-2">

                @if($data->foto)
                    <div class="mt-3">
                        <img src="{{ asset('storage/'.$data->foto) }}"
                             class="w-32 rounded border">
                    </div>
                @endif
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">

            <a href="{{ route('piket.jurnal.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Update
            </button>

        </div>

    </form>

</div>

@endsection