@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="max-w-6xl">

        <h1 class="text-3xl font-semibold mb-6">

            Pengaturan Jam KBM

        </h1>

        @if(session('success'))

            <div class="bg-green-100 text-green-700 border border-green-300 rounded p-3 mb-5">

                {{ session('success') }}

            </div>

        @endif

        <form action="{{ route('admin.jam-kbm.update') }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg shadow border overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="border px-4 py-3">

                                Jam Ke

                            </th>

                            <th class="border px-4 py-3">

                                Jam Mulai

                            </th>

                            <th class="border px-4 py-3">

                                Jam Selesai

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @for($i=1;$i<=10;$i++)

                        <tr>

                            <td class="border px-4 py-3 font-semibold text-center">

                                Jam {{ $i }}

                            </td>

                            <td class="border px-4 py-3">

                                <input

                                    type="time"

                                    name="jam{{ $i }}_mulai"

                                    value="{{ $setting->{'jam'.$i.'_mulai'} }}"

                                    class="w-full border rounded px-3 py-2">

                            </td>

                            <td class="border px-4 py-3">

                                <input

                                    type="time"

                                    name="jam{{ $i }}_selesai"

                                    value="{{ $setting->{'jam'.$i.'_selesai'} }}"

                                    class="w-full border rounded px-3 py-2">

                            </td>

                        </tr>

                        @endfor

                    </tbody>

                </table>

            </div>

            <div class="mt-6 flex justify-end">

                <button

                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection