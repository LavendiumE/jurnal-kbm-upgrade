@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="w-full max-w-5xl">

        <h2 class="text-3xl font-semibold text-gray-800 mb-8">
            Master Data
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- DATA GURU --}}
            <div class="bg-white border rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Data Guru</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Kelola data guru untuk kebutuhan jadwal dan jurnal.
                </p>

                <a href="{{ route('admin.gurus.index') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Kelola Guru
                </a>
            </div>

            {{-- DATA KELAS --}}
            <div class="bg-white border rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Data Kelas</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Tambah dan ubah data kelas sekolah.
                </p>

                <a href="{{ route('admin.kelas.index') }}"
                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Kelola Kelas
                </a>
            </div>

            {{-- DATA MAPEL --}}
            <div class="bg-white border rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Data Mapel</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Kelola mata pelajaran untuk jadwal.
                </p>

                <a href="{{ route('admin.mapels.index') }}"
                   class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                    Kelola Mapel
                </a>
            </div>

            {{-- DATA RUANGAN --}}
            <div class="bg-white border rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Data Ruangan</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Kelola ruangan kelas atau lab.
                </p>

                <a href="{{ route('admin.ruangans.index') }}"
                   class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
                    Kelola Ruangan
                </a>
            </div>

        </div>

    </div>

</div>

@endsection