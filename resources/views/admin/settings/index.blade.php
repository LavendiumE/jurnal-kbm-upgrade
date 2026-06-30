@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="max-w-4xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Pengaturan Sekolah
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola identitas sekolah yang akan ditampilkan pada sistem.
            </p>

        </div>

        {{-- ALERT --}}
        @if(session('success'))

        <div
            class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">

            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24" stroke-width="2">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M5 13l4 4L19 7" />

            </svg>

            <span>{{ session('success') }}</span>

        </div>

        @endif

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

            <form
                action="{{ route('admin.settings.update') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="p-8 space-y-8">

                    {{-- NAMA SEKOLAH --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">

                            Nama Sekolah

                        </label>

                        <input
                            type="text"
                            name="nama_sekolah"
                            value="{{ old('nama_sekolah', $setting->nama_sekolah ?? '') }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        @error('nama_sekolah')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                    {{-- TEKS LOGIN --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">

                            Teks Login

                        </label>

                        <textarea
                            name="teks_login"
                            rows="3"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('teks_login', $setting->teks_login ?? '') }}</textarea>

                        @error('teks_login')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                    {{-- LOGO --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-4">

                            Logo Sekolah

                        </label>

                        <div class="flex flex-col md:flex-row gap-6 items-start">

                            {{-- PREVIEW --}}
                            <div
                                class="w-40 h-40 rounded-2xl border bg-gray-50 flex items-center justify-center overflow-hidden">

                                @if(!empty($setting?->logo))

                                    <img
                                        src="{{ asset('storage/' . $setting->logo) }}"
                                        class="w-full h-full object-contain">

                                @else

                                    <span class="text-gray-400 text-sm">
                                        Belum ada logo
                                    </span>

                                @endif

                            </div>

                            {{-- INPUT --}}
                            <div class="flex-1">

                                <input
                                    type="file"
                                    name="logo"
                                    class="block w-full text-sm
                                    file:mr-4
                                    file:py-2
                                    file:px-4
                                    file:rounded-lg
                                    file:border-0
                                    file:bg-blue-600
                                    file:text-white
                                    hover:file:bg-blue-700">

                                <p class="text-sm text-gray-500 mt-3">
                                    Format: JPG, JPEG, PNG. Maksimal 2 MB.
                                </p>

                                @error('logo')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="border-t px-8 py-5 bg-gray-50">

                    <div class="flex justify-end">

                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 transition">

                            Simpan Pengaturan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection