@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    {{-- HEADER --}}
    <div class="mb-6">

        <div class="flex items-center gap-3 mb-2">

            <a href="{{ route('admin.siswa.kelas', $siswa->kelas_id) }}"
               class="text-gray-500 hover:text-blue-600">

                ← Kembali

            </a>

        </div>

        <h1 class="text-xl font-semibold text-gray-800">
            Edit Data Siswa
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Ubah informasi data siswa
        </p>

    </div>


    {{-- ERROR --}}
    @if($errors->any())

        <div class="mb-5 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">

            <ul class="list-disc pl-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM --}}
    <form
        action="{{ route('admin.siswa.update', $siswa->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="bg-white border rounded-lg p-6 space-y-6 shadow-sm">

            {{-- NIS --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    NIS
                </label>

                <input
                    type="text"
                    name="nis"
                    value="{{ old('nis', $siswa->nis) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan NIS"
                    required>

            </div>


            {{-- NAMA --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Siswa
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama', $siswa->nama) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama siswa"
                    required>

            </div>


            {{-- KELAS --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kelas
                </label>

                <select
                    name="kelas_id"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>

                    @foreach($kelas as $k)

                        <option
                            value="{{ $k->id }}"
                            {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>

                            {{ $k->nama }}

                        </option>

                    @endforeach

                </select>

                <p class="text-xs text-gray-500 mt-1">
                    Jika siswa pindah kelas, pilih kelas tujuan di sini.
                </p>

            </div>


            {{-- NO HP --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    No. HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    value="{{ old('no_hp', $siswa->no_hp) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: 081234567890">

                <p class="text-xs text-gray-500 mt-1">
                    Nomor HP bersifat opsional.
                </p>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 mt-6">

            <a
                href="{{ route('admin.siswa.kelas', $siswa->kelas_id) }}"
                class="px-4 py-2 border rounded-lg hover:bg-gray-50">

                Batal

            </a>

            <button
                type="submit"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">

                Update

            </button>

        </div>

    </form>

</div>

@endsection