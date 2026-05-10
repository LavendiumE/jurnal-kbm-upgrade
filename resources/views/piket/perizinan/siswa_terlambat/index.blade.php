@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                Data Siswa Terlambat
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Daftar siswa yang terlambat
            </p>
        </div>

        <div class="flex gap-3 text-sm">
            <a href="{{ route('piket.perizinan.terlambat.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-lg">
                + Tambah Data
            </a>

            <a href="{{ route('piket.siswa.terlambat.export') }}"
                class="px-4 py-2 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 transition">
                Export
            </a>
        </div>
        
    </div>

    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 border text-center">Nama</th>
                    <th class="px-4 py-3 border text-center">NIS</th>
                    <th class="px-4 py-3 border text-center">Kelas</th>
                    <th class="px-4 py-3 border text-center">Jam</th>
                    <th class="px-4 py-3 border text-center">Guru Pembina</th>
                    <th class="px-4 py-3 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $item)
                <tr class="border-t">

                    <td class="px-4 py-3 border text-center">{{ $item->nama_siswa }}</td>
                    <td class="px-4 py-3 border text-center">{{ $item->nis }}</td>
                    <td class="px-4 py-3 border text-center">{{ $item->kelas->nama ?? '-' }}</td>
                    <td class="px-4 py-3 border text-center">{{ $item->jam_terlambat }}</td>
                    <td class="px-4 py-3 border text-center">{{ $item->guruPembina->nama ?? '-' }}</td>

                    <td class="px-4 py-3 border text-center">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('piket.perizinan.terlambat.edit', $item->id) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <span class="text-gray-400">|</span>

                            <form action="{{ route('piket.perizinan.terlambat.update', $item->id) }}"
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
                        Belum ada data siswa terlambat
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection