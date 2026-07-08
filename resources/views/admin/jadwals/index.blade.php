```blade
@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="w-full max-w-6xl">

        <div class="flex justify-between items-center mb-6">

            <h1 class="text-3xl font-semibold text-gray-800">
                Kelola Jadwal Pelajaran
            </h1>

            <div class="flex items-center gap-3 text-sm">

                <a href="{{ route('admin.jadwals.create') }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                    + Add Jadwal
                </a>

                <a href="{{ route('admin.jadwals.export') }}"
                   class="px-4 py-2 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 transition">
                    Export Jadwal
                </a>

            </div>

        </div>

        <div class="bg-white border rounded-lg overflow-hidden shadow-sm">

            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border text-center">Hari</th>
                        <th class="px-4 py-3 border text-center">Kelas</th>
                        <th class="px-4 py-3 border text-center">Jam</th>
                        <th class="px-4 py-3 border">Mata Pelajaran</th>
                        <th class="px-4 py-3 border">Guru</th>
                        <th class="px-4 py-3 border">Ruangan</th>
                        <th class="px-4 py-3 border">Deadline</th>
                        <th class="px-4 py-3 border text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse ($jadwals as $jadwal)

                    <tr class="hover:bg-gray-50">

                        <td class="border px-4 py-3 text-center">
                            {{ ucfirst($jadwal->hari) }}
                        </td>

                        <td class="border px-4 py-3 text-center">
                            {{ $jadwal->kelas->nama ?? '-' }}
                        </td>

                        <td class="border px-4 py-3 text-center">
                            {{ $jadwal->jam_ke }}
                        </td>

                        <td class="border px-4 py-3">
                            {{ $jadwal->mapel->nama ?? '-' }}
                        </td>

                        <td class="border px-4 py-3">
                            {{ $jadwal->guru->nama ?? '-' }}
                        </td>

                        <td class="border px-4 py-3">
                            {{ $jadwal->ruangan->nama ?? '-' }}
                        </td>

                        <td class="border px-4 py-3 text-center">

                            @if($jadwal->use_default_batas_jurnal)

                                <div class="inline-flex flex-col items-center">

                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        Default
                                    </span>

                                    <span class="text-xs text-gray-500 mt-1">
                                        {{ $setting->batas_jurnal_menit ?? 30 }} menit
                                    </span>

                                </div>

                            @else

                                <div class="inline-flex flex-col items-center">

                                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                        Custom
                                    </span>

                                    <span class="text-xs text-gray-500 mt-1">
                                        {{ $jadwal->batas_jurnal_menit }} menit
                                    </span>

                                </div>

                            @endif

                        </td>

                        <td class="border px-4 py-3 text-center">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.jadwals.edit', $jadwal->id) }}"
                                   class="text-blue-600 hover:underline">
                                    Edit
                                </a>

                                <span class="text-gray-400">|</span>

                                <form action="{{ route('admin.jadwals.destroy', $jadwal->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7"
                            class="px-4 py-10 text-center text-gray-500">
                            Belum ada jadwal
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            <div class="px-4 py-3 border-t">
                {{ $jadwals->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
```
