```blade id="n7m2qp"
@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="w-full max-w-6xl">

        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">
                Edit Jadwal Pelajaran
            </h1>
        </div>

        <form action="{{ route('admin.jadwals.update', $jadwalGroup['kelas_id'].'-'.$jadwalGroup['hari']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white border rounded-lg p-6 mb-6 shadow-sm">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- HARI --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Hari</label>
                        <input type="text"
                               value="{{ ucfirst($jadwalGroup['hari']) }}"
                               class="w-full border rounded px-3 py-2 bg-gray-100"
                               readonly>

                        <input type="hidden" name="hari" value="{{ $jadwalGroup['hari'] }}">
                    </div>

                    {{-- KELAS --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Kelas</label>
                        <input type="text"
                               value="{{ optional($jadwals->first()->kelas)->nama }}"
                               class="w-full border rounded px-3 py-2 bg-gray-100"
                               readonly>
                    </div>

                </div>

            </div>


            <div class="bg-white border rounded-lg overflow-hidden shadow-sm">

                <table class="w-full text-sm">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 border text-center">Jam</th>
                            <th class="px-4 py-3 border">Mapel</th>
                            <th class="px-4 py-3 border">Guru</th>
                            <th class="px-4 py-3 border">Ruangan</th>
                        </tr>
                    </thead>

                    <tbody>

                    @for ($i = 1; $i <= 10; $i++)
                        @php
                            $jadwal = $jadwals->firstWhere('jam_ke', $i);
                        @endphp

                        <tr>

                            <td class="border px-4 py-3 text-center">
                                Jam {{ $i }}
                                <input type="hidden" name="jam_ke[]" value="{{ $i }}">
                            </td>

                            {{-- MAPEL --}}
                            <td class="border px-4 py-3">
                                <select name="mapel_id[]" class="w-full border rounded px-3 py-2">
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach ($mapels as $mapel)
                                        <option value="{{ $mapel->id }}"
                                            {{ optional($jadwal)->mapel_id == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            {{-- GURU --}}
                            <td class="border px-4 py-3">
                                <select name="guru_id[]" class="w-full border rounded px-3 py-2">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($gurus as $guru)
                                        <option value="{{ $guru->id }}"
                                            {{ optional($jadwal)->guru_id == $guru->id ? 'selected' : '' }}>
                                            {{ $guru->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            {{-- RUANGAN --}}
                            <td class="border px-4 py-3">
                                <select name="ruangan_id[]" class="w-full border rounded px-3 py-2">
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach ($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}"
                                            {{ optional($jadwal)->ruangan_id == $ruangan->id ? 'selected' : '' }}>
                                            {{ $ruangan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                        </tr>

                    @endfor

                    </tbody>

                </table>

            </div>

            <div class="flex justify-end gap-3 mt-6">

                <a href="{{ route('admin.jadwals.index') }}"
                   class="px-4 py-2 border rounded">
                    Batal
                </a>

                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded">
                    Update Jadwal
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
```