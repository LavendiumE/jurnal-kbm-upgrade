
@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Edit Data Siswa Terlambat
        </h1>
    </div>

    <form action="{{ route('piket.perizinan.terlambat.update', $data->id) }}"
      method="POST"
      enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white border rounded-lg p-6 space-y-6 shadow-sm">

            {{-- Nama Siswa --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Nama Siswa
                </label>
                <input type="text"
                       name="nama_siswa"
                       value="{{ $data->nama_siswa }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- NIS --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    NIS
                </label>
                <input type="text"
                       name="nis"
                       value="{{ $data->nis }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Tanggal
                </label>
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
                        class="w-full border rounded px-3 py-2">
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ $data->kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jam Terlambat --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Jam Terlambat
                </label>
                <input type="time"
                       name="jam_terlambat"
                       value="{{ $data->jam_terlambat }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Cuaca</label>
                <input type="text"
                    name="cuaca"
                    value="{{ $data->cuaca }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- Alasan --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Alasan
                </label>
                <textarea name="alasan"
                          rows="3"
                          class="w-full border rounded px-3 py-2">{{ $data->alasan }}</textarea>
            </div>

            {{-- Guru Pembina --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Guru Pembina
                </label>
                <select name="guru_pembina_id"
                        class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}"
                            {{ $data->guru_pembina_id == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pembinaan --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Pembinaan
                </label>
                <textarea name="pembinaan"
                          rows="3"
                          class="w-full border rounded px-3 py-2">{{ $data->pembinaan }}</textarea>
            </div>

        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Paraf Guru</label>
            <input type="file"
                name="paraf_guru"
                class="w-full border rounded px-3 py-2">

            @if($data->paraf_guru)
                <a href="{{ asset('storage/'.$data->paraf_guru) }}"
                target="_blank"
                class="text-blue-600 text-sm mt-2 inline-block">
                    Lihat File Saat Ini
                </a>
            @endif
        </div>

        <div class="flex justify-end gap-3 mt-6">

            <a href="{{ route('piket.perizinan.terlambat.index') }}"
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
