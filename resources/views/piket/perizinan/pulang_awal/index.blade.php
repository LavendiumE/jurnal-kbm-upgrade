@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                Data Izin Pulang Lebih Awal
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Daftar siswa yang pulang sebelum jam sekolah selesai
            </p>
        </div>

        <div class="flex gap-3 text-sm">
            <a href="{{ route('piket.perizinan.pulang.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                + Tambah Data
            </a>

            <a href="{{ route('piket.perizinan.pulang.export') }}"
                class="px-4 py-2 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 transition">
                Export
            </a>
        </div>      
    </div>


    {{-- TABLE --}}
    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 border text-center">Nama</th>
                    <th class="px-4 py-3 border text-center">NIS</th>
                    <th class="px-4 py-3 border text-center">Kelas</th>
                    <th class="px-4 py-3 border text-center">Jam Pulang</th>
                    <th class="px-4 py-3 border text-center">Alasan</th>
                    <th class="px-4 py-3 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $item)
                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-3 border text-center">{{ $item->nama }}</td>
                    <td class="px-4 py-3 border text-center">{{ $item->nis }}</td>
                    <td class="px-4 py-3 border text-center">{{ $item->kelas }}</td>
                    <td class="px-4 py-3 border text-center">{{ $item->jam_izin }}</td>
                    <td class="px-4 py-3 border text-center">{{ $item->keperluan }}</td>
                    
                    <td class="px-4 py-3 border text-center">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('piket.perizinan.pulang.edit', $item->id) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <span class="text-gray-400">|</span>

                            <form action="{{ route('piket.perizinan.pulang.update', $item->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-400">
                        Belum ada data izin pulang lebih awal
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection