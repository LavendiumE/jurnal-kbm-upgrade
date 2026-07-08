@extends('layouts.app')

@section('content')


<div class="sm:ml-64 pt-20 px-6 pb-8">
    @if(session('success'))
    <div id="toast-success"
        class="fixed top-5 right-5 z-50 bg-green-500 text-white px-4 py-3 rounded shadow-lg transition-opacity duration-500">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Data Guru</h2>
    </div>

    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Guru</th>
                    <th class="px-4 py-3 text-center">Password</th>
                    <th class="px-4 py-3 text-center">Akses Guru Piket</th>
                    <th class="px-6 py-4 text-center font-semibold">Status</th>
                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $item)
                <tr class="border-b hover:bg-gray-50 transition">

                    {{-- Nama Guru --}}
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            {{ $item->guru->nama ?? $item->name }}
                        </div>

                        <div class="text-xs text-gray-500 mt-1">
                            {{ $item->email }}
                        </div>
                    </td>

                    {{-- Reset Password --}}
                    <td class="px-6 py-4 text-center">

                        <form action="{{ route('admin.gurus.reset-password', $item->id) }}" method="POST">
                            @csrf

                            <button
                                class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-medium hover:bg-blue-700 transition">

                                Reset

                            </button>

                        </form>

                    </td>

                    {{-- Guru Piket --}}
                    <td class="px-6 py-4 text-center">

                        <form action="{{ route('admin.gurus.toggle-piket', $item->id) }}" method="POST">
                            @csrf

                            <button
                                type="submit"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition
                                {{ $item->hasRole('piket') ? 'bg-green-500' : 'bg-gray-300' }}">

                                <span
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition
                                    {{ $item->hasRole('piket') ? 'translate-x-6' : 'translate-x-1' }}">
                                </span>

                            </button>

                        </form>

                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4 text-center">

                        @if($item->is_active)

                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">

                                ● Aktif

                            </span>

                        @else

                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">

                                ● Dimutasi

                            </span>

                        @endif

                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 text-center">

                        @if($item->is_active)

                            <form action="{{ route('admin.gurus.toggle-active',$item->id) }}"
                                    method="POST">

                                @csrf

                                <button
                                    class="px-3 py-1.5 rounded-lg bg-red-500 text-white text-xs font-medium hover:bg-red-600 transition">

                                    Mutasi

                                </button>

                            </form>

                        @else

                        <form action="{{ route('admin.gurus.toggle-active',$item->id) }}"
                            method="POST">

                        @csrf

                           <button
                                class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white text-xs font-medium hover:bg-emerald-700 transition">

                                Aktifkan

                            </button>

                        </form>

                        @endif

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection