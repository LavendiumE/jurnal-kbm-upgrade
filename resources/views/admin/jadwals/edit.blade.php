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
                        <select
                            id="hari"
                            name="hari"
                            class="w-full border rounded px-3 py-2">

                            <option value="Senin" {{ $jadwalGroup['hari']=='senin' ? 'selected' : '' }}>
                                Senin
                            </option>

                            <option value="Selasa" {{ $jadwalGroup['hari']=='selasa' ? 'selected' : '' }}>
                                Selasa
                            </option>

                            <option value="Rabu" {{ $jadwalGroup['hari']=='rabu' ? 'selected' : '' }}>
                                Rabu
                            </option>

                            <option value="Kamis" {{ $jadwalGroup['hari']=='kamis' ? 'selected' : '' }}>
                                Kamis
                            </option>

                            <option value="Jumat" {{ $jadwalGroup['hari']=='jumat' ? 'selected' : '' }}>
                                Jumat
                            </option>

                        </select>
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
                            <th class="px-4 py-3 border">Batas Upload Jurnal</th>
                        </tr>
                    </thead>

                    <tbody>

                    @for ($i = 1; $i <= 10; $i++)
                        @php
                            $jadwal = $jadwals->firstWhere('jam_ke', $i);
                        @endphp

                        <tr>

                           <td class="border px-4 py-3">
                                <div class="space-y-3">

                                    <div class="text-center font-medium">
                                        Jam {{ $i }}
                                    </div>

                                    <input
                                        type="hidden"
                                        name="jam_ke[]"
                                        value="{{ $i }}">

                                    {{-- Preview --}}
                                    <div class="preview-jam text-center">

                                        <div class="text-blue-600 font-semibold">

                                            
                                            <span class="preview-mulai">
                                                {{ optional($jadwal)->jam_mulai ?? $defaultJam[$i][0] }}
                                            </span>

                                            -

                                            <span class="preview-selesai">
                                                {{ optional($jadwal)->jam_selesai ?? $defaultJam[$i][1] }}
                                            </span>

                                        </div>

                                    </div>

                                    {{-- Tombol --}}
                                    <div class="text-center">

                                        <button
                                            type="button"
                                            onclick="toggleJam(this)"
                                            class="btn-edit-jam text-sm text-blue-600 hover:text-blue-800 hover:underline">

                                            Edit Jam

                                        </button>

                                    </div>

                                    {{-- Form Edit --}}
                                    <div class="edit-jam hidden space-y-3">

                                        <div>

                                            <label class="block text-xs text-gray-500 mb-1">

                                                Jam Mulai

                                            </label>

                                            <input
                                                type="time"
                                                name="jam_mulai[]"
                                                value="{{ optional($jadwal)->jam_mulai ?? $defaultJam[$i][0] }}"
                                                class="jam-mulai w-full border rounded px-2 py-1">

                                        </div>

                                        <div>

                                            <label class="block text-xs text-gray-500 mb-1">

                                                Jam Selesai

                                            </label>

                                            <input
                                                type="time"
                                                name="jam_selesai[]"
                                                value="{{ optional($jadwal)->jam_selesai ?? $defaultJam[$i][1] }}"
                                                class="jam-selesai w-full border rounded px-2 py-1">

                                        </div>

                                    </div>

                                </div>

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

                            <td class="border px-4 py-3">

                                @php
                                    $isDefault = optional($jadwal)->use_default_batas_jurnal ?? true;
                                @endphp

                               <div class="space-y-3">

                                    {{-- PENGATURAN DEFAULT --}}
                                    <div>

                                        <label class="inline-flex items-center gap-2 cursor-pointer">

                                            <input
                                                type="checkbox"
                                                class="toggle-default h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                {{ $isDefault ? 'checked' : '' }}
                                                onchange="toggleBatas(this)">

                                            <span class="text-sm font-medium text-gray-700">
                                                Gunakan Setting Global
                                            </span>

                                        </label>

                                        <p class="text-xs text-gray-500 mt-1">
                                            Mengikuti pengaturan jurnal sekolah
                                        </p>

                                    </div>

                                    {{-- Hidden --}}
                                    <input
                                        type="hidden"
                                        class="default-value"
                                        name="use_default_batas_jurnal[]"
                                        value="{{ $isDefault ? 1 : 0 }}">

                                    {{-- DEFAULT INFO --}}
                                    <div class="default-info {{ $isDefault ? '' : 'hidden' }}">

                                        <p class="text-sm text-blue-600 font-medium">
                                            Default :
                                            {{ $setting->toleransi_jurnal ?? 30 }} menit
                                        </p>

                                    </div>

                                    {{-- CUSTOM --}}
                                    <div class="custom-batas {{ $isDefault ? 'hidden' : '' }}">

                                        <label class="block text-xs text-gray-600 mb-1">
                                            Toleransi (menit)
                                        </label>

                                        <input
                                            type="number"
                                            min="1"
                                            name="batas_jurnal_menit[]"
                                            value="{{ optional($jadwal)->batas_jurnal_menit }}"
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

            input.value='';

        }else{

            hidden.value = 0;

            defaultInfo.classList.add('hidden');

            custom.classList.remove('hidden');

            input.focus();

        }

    }

    function toggleJam(button){

        const td = button.closest('td');

        const edit = td.querySelector('.edit-jam');

        edit.classList.toggle('hidden');

        if(edit.classList.contains('hidden')){

            button.innerHTML = 'Edit Jam';
            button.classList.remove('text-red-600');
            button.classList.add('text-blue-600');

        }else{

            button.innerHTML = 'Tutup';
            button.classList.remove('text-blue-600');
            button.classList.add('text-red-600');

        }

    }

    document.querySelectorAll('.jam-mulai, .jam-selesai').forEach(function(input){

        input.addEventListener('input', function(){

            const td = this.closest('td');

            const mulai = td.querySelector('.jam-mulai').value;
            const selesai = td.querySelector('.jam-selesai').value;

            td.querySelector('.preview-mulai').textContent = mulai;
            td.querySelector('.preview-selesai').textContent = selesai;

        });

    });

    document.getElementById('hari').addEventListener('change', function () {

        const hari = this.value;

        if (!hari) return;

        fetch(`/admin/jadwals/jam-kbm/${hari}`)
            .then(response => response.json())
            .then(data => {

                document.querySelectorAll('tbody tr').forEach(function (row, index) {

                    const jamKe = index + 1;

                    if (!data[jamKe]) return;

                    const mulai = data[jamKe][0];
                    const selesai = data[jamKe][1];

                    row.querySelector('.preview-mulai').textContent = mulai;
                    row.querySelector('.preview-selesai').textContent = selesai;

                    row.querySelector('.jam-mulai').value = mulai;
                    row.querySelector('.jam-selesai').value = selesai;

                });

            });

    });

</script>
@endsection
```