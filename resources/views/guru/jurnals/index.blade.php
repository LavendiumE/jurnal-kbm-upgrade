@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    {{-- ACTION BAR --}}
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-xl font-semibold text-gray-800">
            Jurnal KBM
        </h1>

        <div class="flex gap-3 text-sm">

            {{-- ADD --}}
            <a href="{{ route('guru.jurnals.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">

                + Add Jurnal

            </a>

            {{-- EXPORT --}}
            <button
                data-modal-target="exportModal"
                data-modal-toggle="exportModal"
                class="px-4 py-2 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 transition">

                Export My Jurnal

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

                        Export Jurnal

                    </h3>

                    <button
                        type="button"
                        data-modal-hide="exportModal"
                        class="text-gray-400 hover:text-gray-600">

                        ✕

                    </button>

                </div>

                {{-- BODY --}}
                <form method="GET"
                    action="{{ route('guru.jurnals.export.mine') }}">

                    <div class="p-5 space-y-4">

                        {{-- TANGGAL AWAL --}}
                        <div>

                            <label class="block text-sm mb-1">

                                Tanggal Awal

                            </label>

                            <input
                                type="date"
                                name="tanggal_awal"
                                class="w-full border rounded-lg p-2">

                        </div>

                        {{-- TANGGAL AKHIR --}}
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

    @if(isset($informasi) && $informasi)
    <div class="bg-amber-50 border border-amber-200 rounded px-4 py-2 mb-6 text-sm text-amber-800">
        <marquee behavior="scroll" direction="left">
            {{ $informasi->isi }}
        </marquee>
    </div>
    @endif


    {{-- TABLE --}}
    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-4 py-3 text-center">Tanggal</th>
                    <th class="border px-4 py-3 text-center">Jam Mulai</th>
                    <th class="border px-4 py-3 text-center">Jam Selesai</th>
                    <th class="border px-4 py-3 text-center">Kelas</th>
                    <th class="border px-4 py-3 text-center">Mapel</th>
                    <th class="border px-4 py-3 text-left">Materi</th>
                    <th class="border px-4 py-3 text-center">
                        Foto
                    </th>
                    <th class="border px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($jurnals as $jurnal)

                <tr class="hover:bg-gray-50">

                    <td class="border px-4 py-3 text-center">
                        {{ $jurnal->created_at->format('d-m-Y') }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ $jurnal->jadwal->jam_mulai ?? '-' }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ $jurnal->jadwal->jam_selesai ?? '-' }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ $jurnal->kelas->nama ?? '-' }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ $jurnal->jadwal->mapel->nama ?? '-' }}
                    </td>

                    <td class="border px-4 py-3">
                        {{ $jurnal->materi ?? '-' }}
                    </td>

                    <td class="border px-4 py-3 text-center">

                        @if($jurnal->foto)

                            <a href="{{ asset('storage/'.$jurnal->foto) }}"
                            target="_blank"
                            class="text-blue-600 hover:underline">

                                Lihat

                            </a>

                        @else

                            -

                        @endif

                    </td>

                    <td class="border px-4 py-3 text-center">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('guru.jurnals.edit', $jurnal->id) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <span class="text-gray-400">|</span>

                            <form action="{{ route('guru.jurnals.destroy', $jurnal->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus jurnal ini?')">

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
                    <td colspan="7" class="py-8 text-center text-gray-400">
                        Belum ada jurnal
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="px-4 py-3 border-t">
            {{ $jurnals->links() }}
        </div>

    </div>

</div>

@endsection