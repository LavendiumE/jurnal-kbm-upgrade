@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                Data Izin Keluar
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Daftar siswa yang keluar sementara dari sekolah
            </p>
        </div>

        <div class="flex gap-3 text-sm">

            <a href="{{ route('piket.perizinan.keluar.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">

                + Tambah Data

            </a>

            <button
                data-modal-target="exportModal"
                data-modal-toggle="exportModal"
                class="px-4 py-2 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 transition">

                Export

            </button>

        </div>

        {{-- MODAL EXPORT --}}
        <div id="exportModal"
            tabindex="-1"
            aria-hidden="true"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">

            <div class="bg-white rounded-xl shadow-lg w-full max-w-md">

                {{-- HEADER --}}
                <div class="flex items-center justify-between p-4 border-b">

                    <h3 class="text-lg font-semibold">

                        Export Data Izin Keluar

                    </h3>

                    <button
                        type="button"
                        data-modal-hide="exportModal"
                        class="text-gray-400 hover:text-gray-600">

                        ✕

                    </button>

                </div>

                {{-- BODY --}}
                <form
                    method="GET"
                    action="{{ route('piket.perizinan.keluar.export') }}">

                    <div class="p-5 space-y-4">

                        <div>

                            <label class="block text-sm mb-1">

                                Tanggal Awal

                            </label>

                            <input
                                type="date"
                                name="tanggal_awal"
                                class="w-full border rounded-lg p-2">

                        </div>

                        <div>

                            <label class="block text-sm mb-1">

                                Tanggal Akhir

                            </label>

                            <input
                                type="date"
                                name="tanggal_akhir"
                                class="w-full border rounded-lg p-2">

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="flex justify-end gap-2 p-4 border-t">

                        <button
                            type="button"
                            data-modal-hide="exportModal"
                            class="px-4 py-2 border rounded-lg">

                            Batal

                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg">

                            Download

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 border text-center">Nama</th>
                    <th class="px-4 py-3 border text-center">NIS</th>
                    <th class="px-4 py-3 border text-center">Kelas</th>
                    <th class="px-4 py-3 border text-center">Keperluan</th>
                    <th class="px-4 py-3 border text-center">Jam Keluar</th>
                    <th class="px-4 py-3 border text-center">Jam Kembali</th>
                    <th class="px-4 py-3 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $item)
                <tr class="border-t">

                    <td class="px-4 py-3 border text-center">
                        {{ $item->nama }}
                    </td>

                    <td class="px-4 py-3 border text-center">
                        {{ $item->nis }}
                    </td>

                    <td class="px-4 py-3 border text-center">
                        {{ $item->kelas->nama ?? $item->kelas ?? '-' }}
                    </td>

                    <td class="px-4 py-3 border text-center">
                        {{ $item->keperluan }}
                    </td>

                    <td class="px-4 py-3 border text-center">
                        {{ $item->jam_izin }}
                    </td>

                    <td class="px-4 py-3 border text-center">
                        {{ $item->jam_kembali ?? '-' }}
                    </td>

                    <td class="px-4 py-3 border text-center">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('piket.perizinan.keluar.edit', $item->id) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <span class="text-gray-400">|</span>

                            <form action="{{ route('piket.perizinan.keluar.destroy', $item->id) }}"
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
                    <td colspan="7" class="p-4 text-center text-gray-400">
                        Belum ada data izin keluar
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection