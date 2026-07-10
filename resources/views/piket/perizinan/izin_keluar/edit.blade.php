
@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Edit Izin Keluar Sekolah
        </h1>
    </div>

    <form action="{{ route('piket.perizinan.keluar.update', $data->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white border rounded-lg p-6 space-y-6 shadow-sm">

            {{-- Nama Siswa --}}
            <div>
                <label class="block text-sm font-medium mb-2">Nama Siswa</label>
                <input type="text"
                       name="nama"
                       value="{{ $data->nama }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- NIS --}}
            <div>
                <label class="block text-sm font-medium mb-2">NIS</label>
                <input type="text"
                       name="nis"
                       value="{{ $data->nis }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block text-sm font-medium mb-2">Tanggal</label>
                <input type="date"
                       name="tanggal"
                       value="{{ $data->tanggal }}"
                       class="w-full border rounded px-3 py-2 bg-gray-100"
                       readonly>
            </div>

            {{-- Kelas --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full border rounded px-3 py-2"
                        required>

                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ $data->kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Jam Keluar --}}
            <div>
                <label class="block text-sm font-medium mb-2">Jam Keluar</label>
                <input type="time"
                       name="jam_izin"
                       value="{{ $data->jam_izin }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- Jam Kembali --}}
            <div>
                <label class="block text-sm font-medium mb-2">Jam Kembali</label>
                <input type="time"
                       name="jam_kembali"
                       value="{{ $data->jam_kembali }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- Alasan --}}
            <div>
                <label class="block text-sm font-medium mb-2">Alasan</label>
                <textarea name="keperluan"
                rows="3"
                class="w-full border rounded px-3 py-2">{{ old('keperluan', $data->keperluan) }}</textarea>
            </div>

            {{-- Upload Paraf Guru --}}
            <div>
                <label class="block text-sm font-medium mb-2">Paraf Guru</label>

                <input type="file"
                       name="paraf_guru"
                       class="w-full border rounded px-3 py-2">

                @if($data->paraf_guru)
                    <div class="mt-3">
                        <img src="{{ asset('storage/'.$data->paraf_guru) }}"
                             class="w-32 border rounded">
                    </div>
                @endif
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">

            <a href="{{ route('piket.perizinan.keluar.index') }}"
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

