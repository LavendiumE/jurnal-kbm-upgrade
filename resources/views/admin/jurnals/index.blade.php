@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="flex justify-between mb-6">

        <h1 class="text-xl font-semibold">

            Jurnal KBM

        </h1>

        <button
            data-modal-target="exportModal"
            data-modal-toggle="exportModal"
            class="px-4 py-2 border border-blue-500
            text-blue-600 rounded">

            Export All

        </button>

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
                        Materi
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

                <td class="border px-4 py-3">

                    {{ Str::limit($jurnal->materi, 40) }}

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
                class="hidden fixed inset-0 z-50
                bg-black/50 flex items-center justify-center">

                <div class="bg-white rounded-xl
                    w-full max-w-2xl p-6">

                    <div class="flex justify-between mb-4">

                        <h3 class="text-lg font-semibold">

                            Detail Jurnal

                        </h3>

                        <button
                            onclick="closeDetail({{ $jurnal->id }})">

                            ✕

                        </button>

                    </div>

                    <div class="space-y-3 text-sm">

                        <p>
                            <b>Guru :</b>
                            {{ $jurnal->guru->nama ?? '-' }}
                        </p>

                        <p>
                            <b>Kelas :</b>
                            {{ $jurnal->kelas->nama ?? '-' }}
                        </p>

                        <p>
                            <b>Mapel :</b>
                            {{ $jurnal->jadwal->mapel->nama ?? '-' }}
                        </p>

                        <p>
                            <b>Materi :</b>
                            {{ $jurnal->materi }}
                        </p>

                        <p>
                            <b>Kegiatan :</b>
                            {{ $jurnal->kegiatan }}
                        </p>

                        <p>
                            <b>Hadir :</b>
                            {{ $jurnal->hadir }}
                        </p>

                        <p>
                            <b>Izin :</b>
                            {{ $jurnal->izin }}
                        </p>

                        <p>
                            <b>Sakit :</b>
                            {{ $jurnal->sakit }}
                        </p>

                        <p>
                            <b>Alfa :</b>
                            {{ $jurnal->alfa }}
                        </p>

                        @if($jurnal->foto)

                        <div>

                            <p class="font-semibold mb-2">

                                Dokumentasi

                            </p>

                            <img
                                src="{{ asset('storage/'.$jurnal->foto) }}"
                                class="w-64 rounded border">

                        </div>

                        @endif

                    </div>

                </div>

            </div>

            @empty

            <tr>

                <td colspan="6"
                    class="text-center py-8">

                    Belum ada jurnal

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

        <div class="p-4 border-t">

            {{ $jurnals->links() }}

        </div>

    </div>


    {{-- MODAL EXPORT --}}
    <div id="exportModal"
        class="hidden fixed inset-0
        bg-black/50 z-50
        flex items-center justify-center">

        <div class="bg-white rounded-xl p-6 w-full max-w-md">

            <form
                action="{{ route('admin.jurnals.export') }}"
                method="GET">

                <div class="space-y-4">

                    <div>

                        <label>Tanggal Awal</label>

                        <input
                            type="date"
                            name="tanggal_awal"
                            class="w-full border rounded p-2">

                    </div>

                    <div>

                        <label>Tanggal Akhir</label>

                        <input
                            type="date"
                            name="tanggal_akhir"
                            class="w-full border rounded p-2">

                    </div>

                </div>

                <div class="flex justify-end mt-6">

                    <button
                        type="submit"
                        class="bg-blue-600 text-white
                        px-4 py-2 rounded">

                        Download

                    </button>

                </div>

            </form>

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