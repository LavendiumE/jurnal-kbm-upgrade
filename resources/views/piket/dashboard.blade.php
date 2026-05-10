@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <h2 class="text-xl font-semibold mb-6 text-gray-800">
        Dashboard Guru Piket
    </h2>

    @if(isset($informasi) && $informasi)
    <div class="bg-amber-50 border border-amber-200 rounded px-4 py-2 mb-6 text-sm text-amber-800">
        <marquee behavior="scroll" direction="left">
            {{ $informasi->isi }}
        </marquee>
    </div>
    @endif

    {{-- SUMMARY CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-sm text-gray-500">Jurnal Hari Ini</p>
            <p class="text-2xl font-semibold text-blue-600">{{ $jumlahJurnal }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-sm text-gray-500">Perizinan Hari Ini</p>
            <p class="text-2xl font-semibold text-green-600">{{ $jumlahPerizinan }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-sm text-gray-500">Siswa Terlambat</p>
            <p class="text-2xl font-semibold text-orange-500">{{ $jumlahTerlambat }}</p>
        </div>

    </div>


    {{-- JADWAL HARI INI --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">

        <h3 class="text-sm text-gray-500 mb-4">
            Jadwal Hari Ini
        </h3>

        <div class="flex gap-4 overflow-x-auto pb-2">

        @forelse(($jadwalsHariIni ?? []) as $jadwal)

            <div class="min-w-[260px] border rounded-lg p-4 bg-gray-50">

                <div class="mb-3">
                    <p class="text-xs text-gray-400">Kelas</p>
                    <p class="font-medium text-gray-800">
                        {{ $jadwal->kelas->nama ?? '-' }}
                    </p>
                </div>

                <div class="mb-3">
                    <p class="text-xs text-gray-400">Mapel</p>
                    <p class="font-medium text-gray-800">
                        {{ $jadwal->mapel->nama ?? '-' }}
                    </p>
                </div>

                <div class="mb-3">
                    <p class="text-xs text-gray-400">Guru</p>
                    <p class="font-medium text-gray-800">
                        {{ $jadwal->guru->nama ?? '-' }}
                    </p>
                </div>

                <div class="mb-3">
                    <p class="text-xs text-gray-400">Ruangan</p>
                    <p class="font-medium text-gray-800">
                        {{ $jadwal->ruangan->nama ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Jam</p>
                    <p class="font-medium text-blue-600">
                        {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                    </p>
                </div>

            </div>

            @empty

            <div class="text-gray-400 text-sm">
                Belum ada jadwal hari ini
            </div>

            @endforelse

        </div>

    </div>


    {{-- AKTIVITAS TERBARU --}}
    <div class="bg-white rounded-lg shadow p-6">

        <h3 class="text-sm text-gray-500 mb-4">
            Aktivitas Terbaru
        </h3>

        <table class="w-full text-sm">

            <tbody>
            @forelse($aktivitas as $item)
            <tr class="border-t">
                <td class="p-3">{{ $item['nama'] }}</td>
                <td class="p-3">{{ $item['kelas'] }}</td>
                <td class="p-3">{{ $item['jenis'] }}</td>
                <td class="p-3">{{ $item['jam'] }}</td>
            </tr>
            @empty
            <tr class="border-t">
                <td colspan="4" class="p-4 text-center text-gray-400">
                    Belum ada data perizinan
                </td>
            </tr>
            @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection