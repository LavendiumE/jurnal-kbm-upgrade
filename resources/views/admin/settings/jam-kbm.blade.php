@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="max-w-6xl">

        <h1 class="text-3xl font-semibold mb-6">
            Pengaturan Jam KBM
        </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 border border-green-300 rounded-lg px-4 py-3 mb-5">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pilih Hari --}}
        <div class="mb-5">

            <label class="block mb-2 font-medium text-gray-700">

                Hari

            </label>

            <select
                onchange="window.location='{{ route('admin.jam-kbm.index') }}?hari='+this.value"
                class="border rounded-lg px-4 py-2 w-60">

                @foreach($hariList as $item)

                    <option
                        value="{{ $item }}"
                        {{ $hari == $item ? 'selected' : '' }}>

                        {{ $item }}

                    </option>

                @endforeach

            </select>

        </div>

        <form
            action="{{ route('admin.jam-kbm.update') }}"
            method="POST">

            @csrf
            @method('PUT')

            <input
                type="hidden"
                name="hari"
                value="{{ $hari }}">

            <div class="bg-white rounded-xl shadow border overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="border px-4 py-3 w-40">

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

                        @foreach($jamPelajaran as $jam)

                        <tr>

                            <td class="border px-4 py-3 text-center font-semibold">

                                Jam {{ $jam->jam_ke }}

                                <input
                                    type="hidden"
                                    name="jam_ke[]"
                                    value="{{ $jam->jam_ke }}">

                            </td>

                            <td class="border px-4 py-3">

                                <input
                                    type="time"
                                    name="jam_mulai[]"
                                    value="{{ $jam->jam_mulai }}"
                                    class="w-full border rounded-lg px-3 py-2">

                            </td>

                            <td class="border px-4 py-3">

                                <input
                                    type="time"
                                    name="jam_selesai[]"
                                    value="{{ $jam->jam_selesai }}"
                                    class="w-full border rounded-lg px-3 py-2">

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="flex justify-end mt-6">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection