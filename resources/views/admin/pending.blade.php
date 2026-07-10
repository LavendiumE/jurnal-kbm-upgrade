@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="w-full max-w-6xl">

        {{-- TITLE --}}
        <h2 class="text-3xl font-semibold text-gray-800 mb-2">
            Approval User
        </h2>

        <p class="text-sm text-gray-500 mb-6">
            User yang menunggu persetujuan admin
        </p>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-center">Nama</th>
                        <th class="px-4 py-3 text-center">Email</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        $pendingUsers = $users->where('is_approved', 0);
                    @endphp

                    @forelse($pendingUsers as $user)

                    <tr class="border-t hover:bg-gray-50 transition">

                        <td class="px-4 py-3 text-center">
                            {{ $user->name }}
                        </td>

                        <td class="px-4 py-3 text-gray-600 text-center">
                            {{ $user->email }}
                        </td>

                        <td class="px-4 py-3 text-center">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.approve', $user->id) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">

                                    Approve

                                </a>

                                <form action="{{ route('admin.delete-user', $user->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada user yang menunggu approval
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection