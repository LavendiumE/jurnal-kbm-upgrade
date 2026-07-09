@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="max-w-4xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Pengaturan Jurnal
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola aturan batas waktu pengisian jurnal guru agar sesuai dengan jadwal KBM.
            </p>

        </div>

        {{-- ALERT --}}
        @if(session('success'))

        <div
            class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">

            <svg class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 13l4 4L19 7"/>

            </svg>

            <span>{{ session('success') }}</span>

        </div>

        @endif

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

            <form action="{{ route('admin.jurnal-settings.update') }}"
                  method="POST">

                @csrf

                <div class="p-8 space-y-8">

                    {{-- DEFAULT TOLERANSI --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">

                            Toleransi Pengisian Jurnal

                        </label>

                        <div class="flex items-center gap-4">

                            <input
                                type="number"
                                name="toleransi_jurnal"
                                min="0"
                                max="240"
                                value="{{ old('toleransi_jurnal', $setting->toleransi_jurnal ?? 30) }}"
                                class="w-32 border rounded-lg px-3 py-2">

                            <span class="text-gray-600">
                                Menit
                            </span>

                        </div>

                        <p class="mt-3 text-sm text-gray-500">

                            Nilai ini digunakan sebagai batas waktu default
                            setelah jam pelajaran berakhir.

                        </p>

                        @error('toleransi_jurnal')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                    {{-- INFORMASI --}}
                    <div class="rounded-xl border bg-blue-50 border-blue-200 p-5">

                        <div class="flex items-start gap-3">

                            <svg
                                class="w-6 h-6 text-blue-600 mt-0.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>

                            </svg>

                            <div>

                                <h3 class="font-semibold text-blue-700">

                                    Cara Kerja Pengaturan

                                </h3>

                                <ul class="mt-3 text-sm text-gray-700 space-y-2 list-disc ml-5">

                                    <li>
                                        Nilai toleransi akan digunakan sebagai
                                        batas waktu default seluruh jadwal KBM.
                                    </li>

                                    <li>
                                        Admin dapat mengubah toleransi untuk
                                        jadwal tertentu melalui menu
                                        <b>Jadwal KBM</b>.
                                    </li>

                                    <li>
                                        Guru hanya dapat mengisi jurnal
                                        selama jam pelajaran berlangsung
                                        hingga batas toleransi yang ditentukan.
                                    </li>

                                    <li>
                                        Setelah batas waktu berakhir,
                                        jurnal tidak dapat ditambahkan.
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="border-t bg-gray-50 px-8 py-5">

                    <div class="flex justify-end">

                        <button
                            type="submit"
                            class="rounded-xl bg-blue-600 px-6 py-3 font-medium text-white transition hover:bg-blue-700">

                            Simpan Pengaturan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection