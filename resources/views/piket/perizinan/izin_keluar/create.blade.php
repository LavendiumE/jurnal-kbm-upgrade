@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Izin Keluar Sekolah
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Catat siswa yang keluar sekolah sementara pada jam belajar
        </p>
    </div>
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('piket.perizinan.keluar.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="bg-white border rounded-lg p-6 space-y-6 shadow-sm">

            {{-- Nama Siswa --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Nama Siswa
                </label>

                <input type="text"
                       name="nama"
                       class="w-full border rounded px-3 py-2"
                       placeholder="Masukkan nama siswa"
                       required>
            </div>

            {{-- NIS --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    NIS
                </label>

                <input type="text"
                       name="nis"
                       class="w-full border rounded px-3 py-2"
                       placeholder="Masukkan NIS"
                       required>
            </div>

            
            {{-- Tanggal --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Tanggal
                </label>

                <input type="date"
                    name="tanggal"
                    value="{{ date('Y-m-d') }}"
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
                    <option value="">-- Pilih Kelas --</option>

                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Alasan --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Alasan
                </label>

                <textarea name="keperluan"
                          rows="3"
                          class="w-full border rounded px-3 py-2"
                          placeholder="Tuliskan alasan izin keluar"></textarea>
            </div>

            {{-- Jam Izin --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Jam Keluar
                </label>

                <input type="time"
                       name="jam_izin"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            {{-- Jam Kembali --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Jam Kembali
                </label>

                <input type="time"
                       name="jam_kembali"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- Paraf Guru --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Paraf Guru
                </label>

                <input type="file"
                       name="paraf_guru"
                       class="w-full border rounded px-3 py-2">

                <p class="text-xs text-gray-500 mt-1">
                    Upload tanda tangan / bukti izin guru
                </p>
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">

            <a href="{{ route('piket.perizinan.keluar.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Simpan
            </button>

        </div>

    </form>

</div>

@endsection