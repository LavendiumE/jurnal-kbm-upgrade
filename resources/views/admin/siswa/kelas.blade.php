@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <div>

            <div class="flex items-center gap-3 mb-2">

                <a href="{{ route('admin.siswa.index') }}"
                   class="text-gray-500 hover:text-blue-600">

                    ← Kembali

                </a>

            </div>

            <h1 class="text-xl font-semibold text-gray-800">
                Data Siswa {{ $kelas->nama }}
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Daftar siswa pada kelas {{ $kelas->nama }}
            </p>

        </div>


        <div class="flex gap-3 text-sm">

            {{-- TAMBAH SISWA --}}
            <a href="{{ route('admin.siswa.create', $kelas->id) }}"
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">

                + Tambah Siswa

            </a>

        </div>

    </div>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div class="mb-5 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">

            {{ session('success') }}

        </div>

    @endif


    {{-- ERROR MESSAGE --}}
    @if($errors->any())

        <div class="mb-5 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">

            <ul class="list-disc pl-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- INFORMASI KELAS --}}
    <div class="bg-blue-50 border border-blue-100 rounded-lg px-5 py-4 mb-5">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-blue-600">
                    Kelas
                </p>

                <p class="text-lg font-semibold text-blue-800">
                    {{ $kelas->nama }}
                </p>

            </div>


            <div class="text-right">

                <p class="text-sm text-blue-600">
                    Jumlah Siswa
                </p>

                <p class="text-lg font-semibold text-blue-800">
                    {{ $siswa->count() }}
                </p>

            </div>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-700">

                <tr>

                    <th class="px-4 py-3 border text-center">
                        No
                    </th>

                    <th class="px-4 py-3 border text-center">
                        NIS
                    </th>

                    <th class="px-4 py-3 border text-left">
                        Nama Siswa
                    </th>

                    <th class="px-4 py-3 border text-center">
                        No. HP
                    </th>

                    <th class="px-4 py-3 border text-center">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($siswa as $item)

                    <tr class="border-t hover:bg-gray-50">

                        {{-- NO --}}
                        <td class="px-4 py-3 border text-center">
                            {{ $loop->iteration }}
                        </td>


                        {{-- NIS --}}
                        <td class="px-4 py-3 border text-center">
                            {{ $item->nis }}
                        </td>


                        {{-- NAMA --}}
                        <td class="px-4 py-3 border">
                            {{ $item->nama }}
                        </td>


                        {{-- NO HP --}}
                        <td class="px-4 py-3 border text-center">
                            {{ $item->no_hp ?? '-' }}
                        </td>


                        {{-- AKSI --}}
                        <td class="px-4 py-3 border text-center">

                            <div class="flex justify-center items-center gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('admin.siswa.edit', $item->id) }}"
                                   class="text-blue-600 hover:underline">

                                    Edit

                                </a>


                                <span class="text-gray-400">
                                    |
                                </span>


                                {{-- HAPUS --}}
                                <form
                                    action="{{ route('admin.siswa.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600 hover:underline">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="px-4 py-10 text-center text-gray-400">

                            Belum ada siswa di kelas ini.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection