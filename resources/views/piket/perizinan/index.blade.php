@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-6 px-4">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                Perizinan Siswa
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Kelola izin siswa (keluar, pulang lebih awal, terlambat)
            </p>
        </div>


        <!-- BUTTON GROUP -->
        <div class="flex gap-2">

            <a
                href="{{ route('piket.perizinan.keluar.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
            >
                + Izin Keluar
            </a>

            <a
                href="{{ route('piket.perizinan.pulang.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
            >
                + Pulang Lebih Awal
            </a>

            <a
                href="{{ route('piket.perizinan.terlambat.create') }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded"
            >
                + Terlambat
            </a>

        </div>

    </div>



    <!-- TABLE -->
    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700">

                <tr>

                    <th class="px-4 py-3 border text-left">
                        Nama Siswa
                    </th>

                    <th class="px-4 py-3 border text-left">
                        Kelas
                    </th>

                    <th class="px-4 py-3 border text-left">
                        Jurusan
                    </th>

                    <th class="px-4 py-3 border text-left">
                        Jenis Izin
                    </th>

                    <th class="px-4 py-3 border text-left">
                        Jam
                    </th>

                    <th class="px-4 py-3 border text-left">
                        Keterangan
                    </th>

                    <th class="px-4 py-3 border text-center">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($perizinans as $izin)

                <tr class="hover:bg-gray-50">

                    <td class="border px-4 py-3">
                        {{ $izin->nama_siswa }}
                    </td>

                    <td class="border px-4 py-3">
                        {{ $izin->kelas->nama_kelas ?? '-' }}
                    </td>

                    <td class="border px-4 py-3">
                        {{ $izin->jurusan->nama_jurusan ?? '-' }}
                    </td>

                    <td class="border px-4 py-3">

                        @if($izin->jenis == 'keluar')
                            <span class="text-blue-600 font-medium">
                                Izin Keluar
                            </span>

                        @elseif($izin->jenis == 'pulang')
                            <span class="text-green-600 font-medium">
                                Pulang Lebih Awal
                            </span>

                        @elseif($izin->jenis == 'terlambat')
                            <span class="text-yellow-600 font-medium">
                                Terlambat
                            </span>

                        @endif

                    </td>

                    <td class="border px-4 py-3">
                        {{ $izin->jam }}
                    </td>

                    <td class="border px-4 py-3">
                        {{ $izin->keterangan }}
                    </td>

                    <td class="border px-4 py-3 text-center">

                        <div class="flex justify-center gap-2">

                            <a
                                href="{{ route('guru-piket.perizinan.edit',$izin->id) }}"
                                class="text-blue-600 hover:underline"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('guru-piket.perizinan.destroy',$izin->id) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    class="text-red-600 hover:underline"
                                >
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="text-center py-6 text-gray-500">
                        Belum ada data perizinan
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection