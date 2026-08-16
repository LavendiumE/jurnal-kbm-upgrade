@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                Master Data Siswa
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Daftar kelas dan jumlah siswa
            </p>
        </div>

        <div class="flex gap-3 text-sm">

            {{-- IMPORT EXCEL --}}
            <button
                type="button"
                onclick="document.getElementById('importModal').classList.remove('hidden')"
                class="px-4 py-2 border border-green-500 text-green-600 rounded-md hover:bg-green-50 transition">

                Import Excel

            </button>

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


    {{-- DAFTAR KELAS --}}
    <div class="bg-white border rounded-lg overflow-hidden">

        <div class="px-5 py-4 border-b bg-gray-50">

            <h2 class="font-semibold text-gray-800">
                Daftar Kelas
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Pilih kelas untuk melihat daftar siswa
            </p>

        </div>


        <div class="p-5">

            @if($kelas->count())

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                    @foreach($kelas as $item)

                        <div
                            class="border rounded-xl p-5 hover:border-blue-400 hover:shadow-sm transition bg-white">

                            {{-- ICON + NAMA KELAS --}}
                            <div class="flex items-start justify-between">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-5 h-5">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4.5 6.75h15m-15 5.25h15m-15 5.25h15" />

                                        </svg>

                                    </div>


                                    <div>

                                        <h3 class="font-semibold text-gray-800">
                                            {{ $item->nama }}
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            {{ $item->siswa_count }} siswa
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- BUTTON --}}
                            <div class="mt-5">

                                <a
                                    href="{{ route('admin.siswa.kelas', $item->id) }}"
                                    class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">

                                    Lihat Siswa

                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="py-12 text-center">

                    <div class="text-gray-400 mb-3">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-10 h-10 mx-auto">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6.75a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM4.5 21a7.5 7.5 0 0 1 15 0" />

                        </svg>

                    </div>

                    <p class="text-gray-400">
                        Belum ada data kelas.
                    </p>

                    <p class="text-sm text-gray-400 mt-1">
                        Tambahkan kelas terlebih dahulu melalui Master Data Kelas.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- IMPORT MODAL --}}
{{-- ========================================================= --}}

<div
    id="importModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md">

        {{-- HEADER MODAL --}}
        <div class="flex items-center justify-between p-5 border-b">

            <div>

                <h3 class="text-lg font-semibold text-gray-800">
                    Import Data Siswa
                </h3>

                <p class="text-xs text-gray-500 mt-1">
                    Upload file Excel data siswa
                </p>

            </div>


            <button
                type="button"
                onclick="document.getElementById('importModal').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl">

                ✕

            </button>

        </div>


        {{-- FORM IMPORT --}}
        <form
            action="{{ route('admin.siswa.import') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="p-5 space-y-5">

                {{-- FILE --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        File Excel
                    </label>

                    <input
                        type="file"
                        name="file"
                        accept=".xlsx,.xls,.csv"
                        required
                        class="w-full border rounded-lg px-3 py-2 text-sm">

                    <p class="text-xs text-gray-500 mt-2">
                        Format kolom:
                        <strong>NIS, Nama, Kelas, No HP</strong>
                    </p>

                </div>


                {{-- INFORMASI --}}
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">

                    <p class="text-xs text-blue-700 leading-relaxed">

                        Pastikan nama kelas pada Excel sama persis dengan
                        nama kelas yang tersedia di Master Data Kelas.

                    </p>

                </div>


                {{-- FORMAT EXCEL --}}
                <div class="bg-gray-50 border rounded-lg p-4">

                    <p class="text-xs font-semibold text-gray-700 mb-2">
                        Format Excel
                    </p>

                    <div class="text-xs text-gray-600 space-y-1">

                        <p>
                            <strong>nis</strong> :
                            NIS siswa
                        </p>

                        <p>
                            <strong>nama</strong> :
                            Nama siswa
                        </p>

                        <p>
                            <strong>kelas</strong> :
                            Nama kelas
                        </p>

                        <p>
                            <strong>no_hp</strong> :
                            Nomor HP siswa
                        </p>

                    </div>

                </div>

            </div>


            {{-- FOOTER MODAL --}}
            <div class="flex justify-end gap-2 p-4 border-t">

                <button
                    type="button"
                    onclick="document.getElementById('importModal').classList.add('hidden')"
                    class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-50">

                    Batal

                </button>


                <button
                    type="submit"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">

                    Import

                </button>

            </div>

        </form>

    </div>

</div>

@endsection