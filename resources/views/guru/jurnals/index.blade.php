@extends('layouts.app')

@section('content')

@php
    $isKurikulum = auth()->user()->hasRole('kurikulum');
@endphp

<div class="sm:ml-64 pt-20 px-6 pb-8">

    {{-- ===================================================== --}}
    {{-- ACTION BAR --}}
    {{-- ===================================================== --}}

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                @if($isKurikulum)
                    Jurnal KBM Guru
                @else
                    Jurnal KBM
                @endif
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                @if($isKurikulum)
                    Melihat dan mengekspor seluruh jurnal guru
                @else
                    Jurnal kegiatan belajar mengajar
                @endif
            </p>
        </div>


        <div class="flex gap-3 text-sm">

            {{-- ================================================= --}}
            {{-- GURU BIASA --}}
            {{-- ================================================= --}}

            @if(!$isKurikulum)

                {{-- ADD JURNAL --}}
                <a href="{{ route('guru.jurnals.create') }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">

                    + Add Jurnal

                </a>


                {{-- EXPORT JURNAL SENDIRI --}}
                <button
                    type="button"
                    data-modal-target="exportModal"
                    data-modal-toggle="exportModal"
                    class="px-4 py-2 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 transition">

                    Export My Jurnal

                </button>

            @else

                {{-- ================================================= --}}
                {{-- GURU KURIKULUM --}}
                {{-- ================================================= --}}

                <button
                    type="button"
                    data-modal-target="exportAllModal"
                    data-modal-toggle="exportAllModal"
                    class="px-4 py-2 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 transition">

                    Export All Jurnal

                </button>

            @endif

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- INFORMASI --}}
    {{-- ===================================================== --}}

    @if(isset($informasi) && $informasi)

        <div class="bg-amber-50 border border-amber-200 rounded px-4 py-2 mb-6 text-sm text-amber-800">

            <marquee behavior="scroll" direction="left">
                {{ $informasi->isi }}
            </marquee>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- TABLE --}}
    {{-- ===================================================== --}}

    <div class="bg-white border rounded-lg overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-700">

                    <tr>

                        <th class="border px-4 py-3 text-center">
                            Tanggal
                        </th>


                        {{-- KOLOM GURU HANYA UNTUK KURIKULUM --}}
                        @if($isKurikulum)

                            <th class="border px-4 py-3 text-left">
                                Guru
                            </th>

                        @endif


                        <th class="border px-4 py-3 text-center">
                            Jam Mulai
                        </th>

                        <th class="border px-4 py-3 text-center">
                            Jam Selesai
                        </th>

                        <th class="border px-4 py-3 text-center">
                            Kelas
                        </th>

                        <th class="border px-4 py-3 text-center">
                            Mapel
                        </th>

                        <th class="border px-4 py-3 text-left">
                            Materi
                        </th>

                        <th class="border px-4 py-3 text-center">
                            Foto
                        </th>


                        {{-- AKSI HANYA GURU BIASA --}}
                        @if(!$isKurikulum)

                            <th class="border px-4 py-3 text-center">
                                Aksi
                            </th>

                        @endif

                    </tr>

                </thead>


                <tbody>

                    @forelse($jurnals as $jurnal)

                        <tr class="hover:bg-gray-50">


                            {{-- TANGGAL --}}
                            <td class="border px-4 py-3 text-center">

                                {{ $jurnal->created_at
                                    ? $jurnal->created_at->format('d-m-Y')
                                    : '-' }}

                            </td>


                            {{-- GURU --}}
                            @if($isKurikulum)

                                <td class="border px-4 py-3">

                                    <div class="font-medium text-gray-800">

                                        {{ $jurnal->guru->nama ?? '-' }}

                                    </div>

                                </td>

                            @endif


                            {{-- JAM MULAI --}}
                            <td class="border px-4 py-3 text-center">

                                {{ $jurnal->jadwal->jam_mulai ?? '-' }}

                            </td>


                            {{-- JAM SELESAI --}}
                            <td class="border px-4 py-3 text-center">

                                {{ $jurnal->jadwal->jam_selesai ?? '-' }}

                            </td>


                            {{-- KELAS --}}
                            <td class="border px-4 py-3 text-center">

                                {{ $jurnal->kelas->nama ?? '-' }}

                            </td>


                            {{-- MAPEL --}}
                            <td class="border px-4 py-3 text-center">

                                {{ $jurnal->jadwal->mapel->nama ?? '-' }}

                            </td>


                            {{-- MATERI --}}
                            <td class="border px-4 py-3">

                                {{ $jurnal->materi ?? '-' }}

                            </td>


                            {{-- FOTO --}}
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


                            {{-- ================================================= --}}
                            {{-- AKSI GURU BIASA --}}
                            {{-- ================================================= --}}

                            @if(!$isKurikulum)

                                <td class="border px-4 py-3 text-center">

                                    <div class="flex justify-center gap-2">

                                        {{-- EDIT --}}
                                        <a href="{{ route('guru.jurnals.edit', $jurnal->id) }}"
                                           class="text-blue-600 hover:underline">

                                            Edit

                                        </a>


                                        <span class="text-gray-400">
                                            |
                                        </span>


                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('guru.jurnals.destroy', $jurnal->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin hapus jurnal ini?')">

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

                            @endif

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ $isKurikulum ? 9 : 8 }}"
                                class="py-8 text-center text-gray-400">

                                @if($isKurikulum)

                                    Belum ada jurnal guru.

                                @else

                                    Belum ada jurnal.

                                @endif

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        <div class="px-4 py-3 border-t">

            {{ $jurnals->links() }}

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAL EXPORT GURU BIASA --}}
{{-- ========================================================= --}}

@if(!$isKurikulum)

<div
    id="exportModal"
    tabindex="-1"
    aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md">

        {{-- HEADER --}}

        <div class="flex items-center justify-between p-4 border-b">

            <div>

                <h3 class="text-lg font-semibold text-gray-800">
                    Export Jurnal Saya
                </h3>

                <p class="text-xs text-gray-500 mt-1">
                    Pilih rentang tanggal jurnal
                </p>

            </div>

            <button
                type="button"
                data-modal-hide="exportModal"
                class="text-gray-400 hover:text-gray-600 text-xl">

                ✕

            </button>

        </div>


        {{-- FORM --}}

        <form
            method="GET"
            action="{{ route('guru.jurnals.export.mine') }}">

            <div class="p-5 space-y-4">

                {{-- TANGGAL AWAL --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Awal
                    </label>

                    <input
                        type="date"
                        name="tanggal_awal"
                        class="w-full border rounded-lg p-2">

                </div>


                {{-- TANGGAL AKHIR --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
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
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                    Download

                </button>

            </div>

        </form>

    </div>

</div>

@endif



{{-- ========================================================= --}}
{{-- MODAL EXPORT ALL - GURU KURIKULUM --}}
{{-- ========================================================= --}}

@if($isKurikulum)

<div
    id="exportAllModal"
    tabindex="-1"
    aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md">

        {{-- HEADER --}}

        <div class="flex items-center justify-between p-4 border-b">

            <div>

                <h3 class="text-lg font-semibold text-gray-800">
                    Export Semua Jurnal
                </h3>

                <p class="text-xs text-gray-500 mt-1">
                    Export jurnal seluruh guru berdasarkan tanggal
                </p>

            </div>

            <button
                type="button"
                data-modal-hide="exportAllModal"
                class="text-gray-400 hover:text-gray-600 text-xl">

                ✕

            </button>

        </div>


        {{-- FORM --}}

        <form
            method="GET"
            action="{{ route('guru.kurikulum.jurnals.export') }}">

            <div class="p-5 space-y-4">

                {{-- TANGGAL AWAL --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Awal
                    </label>

                    <input
                        type="date"
                        name="tanggal_awal"
                        class="w-full border rounded-lg p-2">

                </div>


                {{-- TANGGAL AKHIR --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
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
                    data-modal-hide="exportAllModal"
                    class="px-4 py-2 border rounded-lg">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                    Download

                </button>

            </div>

        </form>

    </div>

</div>

@endif

@endsection