@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    {{-- ACTION BAR --}}
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-xl font-semibold text-gray-800">
            Jurnal KBM
        </h1>

        <div class="flex gap-3 text-sm">

            <a href="{{ route('guru.jurnals.create') }}"
               class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                + Add Jurnal
            </a>

            <a href="{{ route('guru.jurnals.export.mine') }}"
               class="px-4 py-2 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 transition">
                Export My Jurnal
            </a>

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