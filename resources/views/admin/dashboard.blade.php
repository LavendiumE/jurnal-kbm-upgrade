
@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="w-full max-w-6xl">

        {{-- TITLE --}}
        <h2 class="text-3xl font-semibold text-gray-800 mb-8">
            Dashboard Admin
        </h2>

        <button onclick="openModal('modalInformasi')"
                class="mb-6 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-sm transition">
            <span class="text-lg leading-none">+</span>
            <span>Informasi</span>
        </button>

        @if(session('success'))

        <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">

            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 13l4 4L19 7"/>

            </svg>

            <span>{{ session('success') }}</span>

        </div>

        @endif

        {{-- CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            {{-- TOTAL GURU --}}
            <div class="bg-white p-5 rounded-lg shadow-sm border">
                <p class="text-sm text-gray-500 mb-1">
                    Total Guru
                </p>

                <p class="text-2xl font-bold text-green-600">
                    {{ $totalGuru ?? 0 }}
                </p>
            </div>

            {{-- PENDING --}}
            <div class="bg-white p-5 rounded-lg shadow-sm border">
                <p class="text-sm text-gray-500 mb-1">
                    Pending Approval
                </p>

                <p class="text-2xl font-bold text-orange-500">
                    {{ $pending ?? 0 }}
                </p>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-lg shadow-sm border p-5">

            <h3 class="text-sm text-gray-500 mb-4">
                Recent Activity
            </h3>

            <div class="overflow-x-auto">

                <table class="w-full text-sm border-collapse">

                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left border-b">Guru</th>
                            <th class="px-4 py-3 text-center border-b">Kelas</th>
                            <th class="px-4 py-3 text-center border-b">Mapel</th>
                            <th class="px-4 py-3 text-center border-b">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($recent as $r)

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3">
                                {{ $r->guru->nama ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $r->kelas->nama ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $r->mapel->nama ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center text-gray-500">
                                {{ $r->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                                Belum ada aktivitas
                            </td>
                        </tr>

                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div id="modalInformasi" class="hidden fixed inset-0 bg-black/30 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-full max-w-md">

            <h3 class="text-lg font-semibold mb-4">Tambah Informasi</h3>

            <form action="{{ route('admin.informasi.store') }}" method="POST">
                @csrf

                <textarea name="isi"
                        rows="4"
                        class="w-full border rounded px-3 py-2 mb-4"
                        placeholder="Tulis informasi"></textarea>

                <div class="flex justify-end gap-2">
                    <button type="button"
                            onclick="closeModal('modalInformasi')"
                            class="px-4 py-2 border rounded">
                        Batal
                    </button>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

    <script>
    function openModal(id){
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id){
        document.getElementById(id).classList.add('hidden');
    }
    </script>

</div>

@endsection