@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="flex justify-between mb-6">

        <h1 class="text-xl font-semibold">

            Jurnal Guru Piket

        </h1>

        <a
            href="{{ route('admin.jurnal-piket.export') }}"
            class="px-4 py-2 border border-blue-500 text-blue-600 rounded hover:bg-blue-50">

            Export All

        </a>

    </div>

    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100">

                <tr>

                    <th class="border px-4 py-3">
                        Tanggal
                    </th>

                    <th class="border px-4 py-3">
                        Guru
                    </th>

                    <th class="border px-4 py-3">
                        Kelas
                    </th>

                    <th class="border px-4 py-3">
                        Mapel
                    </th>

                    <th class="border px-4 py-3">
                        Jam
                    </th>

                    <th class="border px-4 py-3">
                        Ruangan
                    </th>

                    <th class="border px-4 py-3">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($jurnals as $jurnal)

            <tr>

                <td class="border px-4 py-3 text-center">

                    {{ $jurnal->created_at->format('d-m-Y') }}

                </td>

                <td class="border px-4 py-3">

                    {{ $jurnal->guru->nama ?? '-' }}

                </td>

                <td class="border px-4 py-3">

                    {{ $jurnal->kelas->nama ?? '-' }}

                </td>

                <td class="border px-4 py-3">

                    {{ $jurnal->jadwal->mapel->nama ?? '-' }}

                </td>

                <td class="border px-4 py-3 text-center">

                    {{ $jurnal->jadwal->jam_mulai ?? '-' }}
                    -
                    {{ $jurnal->jadwal->jam_selesai ?? '-' }}

                </td>

                <td class="border px-4 py-3 text-center">

                    {{ $jurnal->jadwal->ruangan->nama ?? '-' }}

                </td>

                <td class="border px-4 py-3 text-center">

                    <button
                        onclick="openDetail({{ $jurnal->id }})"
                        class="text-blue-600 hover:underline">

                        Lihat

                    </button>

                </td>

            </tr>

            {{-- MODAL DETAIL --}}
            <div
                id="detail-{{ $jurnal->id }}"
                class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">

                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">

                    {{-- Header --}}
                    <div class="flex items-center justify-between px-6 py-5 border-b">

                        <div>

                            <h2 class="text-xl font-bold text-gray-800">
                                Detail Jurnal Guru Piket
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $jurnal->created_at->format('d F Y') }}
                            </p>

                        </div>

                        <button
                            onclick="closeDetail({{ $jurnal->id }})"
                            class="w-10 h-10 rounded-full hover:bg-gray-100 transition">

                            ✕

                        </button>

                    </div>

                    <div class="p-6 space-y-6">

                        {{-- Informasi Utama --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase">Guru</p>
                                <p class="font-semibold mt-1">
                                    {{ $jurnal->guru->nama ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase">Kelas</p>
                                <p class="font-semibold mt-1">
                                    {{ $jurnal->kelas->nama ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase">Mapel</p>
                                <p class="font-semibold mt-1">
                                    {{ $jurnal->jadwal->mapel->nama ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase">Ruangan</p>
                                <p class="font-semibold mt-1">
                                    {{ $jurnal->jadwal->ruangan->nama ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase">Jam</p>
                                <p class="font-semibold mt-1">
                                    {{ $jurnal->jadwal->jam_mulai ?? '-' }}
                                    -
                                    {{ $jurnal->jadwal->jam_selesai ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase">PKL</p>
                                <p class="font-semibold mt-1">
                                    {{ $jurnal->pkl ?? '-' }}
                                </p>
                            </div>

                        </div>

                        {{-- Materi --}}
                        <div>

                            <h3 class="font-semibold text-gray-700 mb-2">

                                Materi

                            </h3>

                            <div class="bg-gray-50 rounded-xl p-4 text-gray-700 leading-relaxed">

                                {{ $jurnal->materi ?: '-' }}

                            </div>

                        </div>

                        {{-- Kegiatan --}}
                        <div>

                            <h3 class="font-semibold text-gray-700 mb-2">

                                Kegiatan

                            </h3>

                            <div class="bg-gray-50 rounded-xl p-4 text-gray-700 leading-relaxed">

                                {{ $jurnal->kegiatan ?: '-' }}

                            </div>

                        </div>

                        {{-- Kehadiran --}}
                        <div>

                            <h3 class="font-semibold text-gray-700 mb-3">

                                Rekap Kehadiran

                            </h3>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                                <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">

                                    <p class="text-sm text-gray-500">Hadir</p>

                                    <p class="text-2xl font-bold text-green-600">

                                        {{ $jurnal->hadir ?? 0 }}

                                    </p>

                                </div>

                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">

                                    <p class="text-sm text-gray-500">Izin</p>

                                    <p class="text-2xl font-bold text-blue-600">

                                        {{ $jurnal->izin ?? 0 }}

                                    </p>

                                </div>

                                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">

                                    <p class="text-sm text-gray-500">Sakit</p>

                                    <p class="text-2xl font-bold text-yellow-600">

                                        {{ $jurnal->sakit ?? 0 }}

                                    </p>

                                </div>

                                <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">

                                    <p class="text-sm text-gray-500">Alfa</p>

                                    <p class="text-2xl font-bold text-red-600">

                                        {{ $jurnal->alfa ?? 0 }}

                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- Dokumentasi --}}
                        @if($jurnal->foto)

                        <div>

                            <h3 class="font-semibold text-gray-700 mb-3">

                                Dokumentasi

                            </h3>

                            <div class="flex justify-center">

                                <img
                                    src="{{ asset('storage/'.$jurnal->foto) }}"
                                    class="rounded-xl border shadow max-h-[420px] object-contain">

                            </div>

                        </div>

                        @endif

                    </div>

                </div>

            </div>
            @empty

            <tr>

                <td colspan="7"
                    class="text-center py-8">

                    Belum ada jurnal guru piket

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

        <div class="p-4 border-t">

            {{ $jurnals->links() }}

        </div>

    </div>

</div>

<script>

function openDetail(id){

    document
        .getElementById('detail-'+id)
        .classList.remove('hidden');

}

function closeDetail(id){

    document
        .getElementById('detail-'+id)
        .classList.add('hidden');

}

</script>

@endsection