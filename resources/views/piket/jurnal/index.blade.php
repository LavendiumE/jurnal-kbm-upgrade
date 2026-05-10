@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-xl font-semibold text-gray-800">
            Jurnal Guru Piket
        </h1>

        <div class="flex gap-2">

            
            <a href="{{ route('piket.jurnal.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                + Add Jurnal
            </a>

            <a href="{{ route('piket.jurnal.export') }}"
            class="px-4 py-2 border border-green-500 text-green-600 rounded hover:bg-green-50 transition">
                Export
            </a>


        </div>

    </div>

    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-4 py-3 text-center">Tanggal</th>
                    <th class="border px-4 py-3 text-center">Hari</th>
                    <th class="border px-4 py-3 text-center">Jam</th>
                    <th class="border px-4 py-3 text-center">Kelas</th>
                    <th class="border px-4 py-3 text-center">Mapel</th>
                    <th class="border px-4 py-3 text-center">Guru</th>
                    <th class="border px-4 py-3 text-center">Ruangan</th>
                    <th class="border px-4 py-3 text-center">Foto</th>
                    <th class="border px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $item)

                <tr class="hover:bg-gray-50">

                    <td class="border px-4 py-3 text-center">
                        {{ $item->created_at->format('d-m-Y') }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ ucfirst($item->jadwal->hari ?? '-') }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ $item->jadwal->jam_mulai ?? '-' }} - {{ $item->jadwal->jam_selesai ?? '-' }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ $item->kelas->nama ?? '-' }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ $item->jadwal->mapel->nama ?? '-' }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ $item->guru->nama ?? '-' }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        {{ $item->jadwal->ruangan->nama ?? '-' }}
                    </td>

                    <td class="border px-4 py-3 text-center">
                        @if($item->foto)
                            <a href="{{ asset('storage/'.$item->foto) }}"
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

                        <a href="{{ route('piket.jurnal.edit', $item->id) }}"
                        class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        <span class="text-gray-400">|</span>

                        <form action="{{ route('piket.jurnal.destroy', $item->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus jurnal ini?')">

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
                    <td colspan="9" class="py-8 text-center text-gray-400">
                        Belum ada jurnal piket
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="px-4 py-3 border-t">
            {{ $data->links() }}
        </div>

    </div>

</div>

@endsection