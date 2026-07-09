```blade
@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="w-full max-w-6xl">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">
                Tambah Jadwal Pelajaran
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Isi jadwal pelajaran untuk satu kelas dalam satu hari
            </p>
        </div>

        <form action="{{ route('admin.jadwals.store') }}" method="POST">
            @csrf

            {{-- HEADER FORM --}}
            <div class="bg-white border rounded-lg p-6 mb-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- HARI --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Hari</label>

                        <select name="hari"
                                class="w-full border rounded px-3 py-2"
                                required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                        </select>
                    </div>

                    {{-- KELAS --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Kelas</label>

                        <select name="kelas_id"
                                class="w-full border rounded px-3 py-2"
                                required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>


            {{-- TABLE --}}
            <div class="bg-white border rounded-lg overflow-hidden shadow-sm">

                <table class="w-full text-sm">

                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 border text-center w-24">Jam</th>
                            <th class="px-4 py-3 border text-left">Mata Pelajaran</th>
                            <th class="px-4 py-3 border text-left">Guru</th>
                            <th class="px-4 py-3 border text-left">Ruangan</th>
                            <th class="px-4 py-3 border text-center w-64">
                                Batas Upload Jurnal
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @for ($i = 1; $i <= 10; $i++)
                        <tr class="hover:bg-gray-50">

                            <td class="border px-4 py-3 text-center font-medium">
                                Jam {{ $i }}
                                <input type="hidden" name="jam_ke[]" value="{{ $i }}">
                            </td>

                            {{-- MAPEL --}}
                            <td class="border px-4 py-3">
                                <select name="mapel_id[]"
                                        class="w-full border rounded px-3 py-2">
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach ($mapels as $mapel)
                                        <option value="{{ $mapel->id }}">
                                            {{ $mapel->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            {{-- GURU --}}
                            <td class="border px-4 py-3">
                                <select name="guru_id[]"
                                        class="w-full border rounded px-3 py-2">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($gurus as $guru)
                                        <option value="{{ $guru->id }}">
                                            {{ $guru->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            {{-- RUANGAN --}}
                            <td class="border px-4 py-3">
                                <select name="ruangan_id[]"
                                        class="w-full border rounded px-3 py-2">
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach ($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}">
                                            {{ $ruangan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="border px-4 py-3">

                                {{-- PENGATURAN BATAS JURNAL --}}
                                <div class="space-y-3">

                                    <div>

                                        <label class="inline-flex items-center gap-2 cursor-pointer">

                                            <input
                                                type="checkbox"
                                                checked
                                                onchange="toggleBatas(this)"
                                                class="toggle-default h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                                            <span class="text-sm font-medium text-gray-700">
                                                Gunakan Setting Global
                                            </span>

                                        </label>

                                        <p class="text-xs text-gray-500 mt-1">
                                            Mengikuti pengaturan jurnal sekolah
                                        </p>

                                    </div>

                                    {{-- Hidden Value --}}
                                    <input
                                        type="hidden"
                                        class="default-value"
                                        name="use_default_batas_jurnal[]"
                                        value="1">

                                    {{-- INFO DEFAULT --}}
                                    <div class="default-info">

                                        <p class="text-sm text-blue-600 font-medium">
                                            Default :
                                            {{ $setting->toleransi_jurnal ?? 30 }} menit
                                        </p>

                                    </div>

                                    {{-- CUSTOM --}}
                                    <div class="custom-batas hidden">

                                        <label class="block text-xs text-gray-600 mb-1">
                                            Toleransi (menit)
                                        </label>

                                        <input
                                            type="number"
                                            min="1"
                                            name="batas_jurnal_menit[]"
                                            class="custom-input w-full border rounded px-3 py-2"
                                            placeholder="45">

                                    </div>

                                </div>

                            </td>

                        </tr>
                        @endfor

                    </tbody>

                </table>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 mt-6">

                <a href="{{ route('admin.jadwals.index') }}"
                   class="px-4 py-2 border rounded">
                    Batal
                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    Simpan Jadwal
                </button>

            </div>

        </form>

    </div>

</div>

<script>

    function toggleBatas(el){

        const td = el.closest('td');

        const hidden = td.querySelector('.default-value');

        const defaultInfo = td.querySelector('.default-info');

        const custom = td.querySelector('.custom-batas');

        const input = td.querySelector('.custom-input');

        if(el.checked){

            hidden.value = 1;

            defaultInfo.classList.remove('hidden');

            custom.classList.add('hidden');

            input.value = '';

        }else{

            hidden.value = 0;

            defaultInfo.classList.add('hidden');

            custom.classList.remove('hidden');

            input.focus();

        }

    }

</script>
@endsection
```
