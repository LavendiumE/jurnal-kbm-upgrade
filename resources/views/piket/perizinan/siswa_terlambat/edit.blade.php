@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Edit Data Siswa Terlambat
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Ubah data keterlambatan siswa
        </p>
    </div>


    {{-- ERROR --}}
    @if ($errors->any())

        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">

            <ul class="list-disc pl-5">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('piket.perizinan.terlambat.update', $data->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')


        <div class="bg-white border rounded-lg p-6 space-y-6 shadow-sm">


            {{-- KELAS --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Kelas
                </label>

                <select
                    id="kelas_id"
                    name="kelas_id"
                    class="w-full border rounded px-3 py-2"
                    required>

                    <option value="">
                        -- Pilih Kelas --
                    </option>

                    @foreach ($kelas as $k)

                        <option
                            value="{{ $k->id }}"
                            {{ $data->kelas_id == $k->id ? 'selected' : '' }}>

                            {{ $k->nama }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- NAMA SISWA --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Nama Siswa
                </label>

                <select
                    id="siswa_select"
                    class="w-full border rounded px-3 py-2"
                    required>

                    <option value="">
                        -- Pilih Siswa --
                    </option>

                    @foreach ($siswa as $s)

                        <option
                            value="{{ $s->id }}"
                            data-kelas="{{ $s->kelas_id }}"
                            data-nis="{{ $s->nis }}"
                            data-nama="{{ $s->nama }}">

                            {{ $s->nama }}

                        </option>

                    @endforeach

                </select>


                {{-- Nama yang dikirim ke controller --}}
                <input
                    type="hidden"
                    name="nama_siswa"
                    id="nama_siswa"
                    value="{{ old('nama_siswa', $data->nama_siswa) }}">

            </div>


            {{-- NIS --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    NIS
                </label>

                <input
                    type="text"
                    name="nis"
                    id="nis"
                    value="{{ old('nis', $data->nis) }}"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    placeholder="NIS otomatis terisi"
                    readonly
                    required>

            </div>


            {{-- TANGGAL --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ $data->tanggal }}"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    readonly>

            </div>


            {{-- JAM TERLAMBAT --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Jam Terlambat
                </label>

                <input
                    type="time"
                    name="jam_terlambat"
                    value="{{ $data->jam_terlambat }}"
                    class="w-full border rounded px-3 py-2">

            </div>


            {{-- CUACA --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Cuaca
                </label>

                <input
                    type="text"
                    name="cuaca"
                    value="{{ old('cuaca', $data->cuaca) }}"
                    class="w-full border rounded px-3 py-2">

            </div>


            {{-- ALASAN --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Alasan
                </label>

                <textarea
                    name="alasan"
                    rows="3"
                    class="w-full border rounded px-3 py-2">{{ old('alasan', $data->alasan) }}</textarea>

            </div>


            {{-- GURU PEMBINA --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Guru Pembina
                </label>

                <select
                    name="guru_pembina_id"
                    class="w-full border rounded px-3 py-2">

                    <option value="">
                        -- Pilih Guru --
                    </option>

                    @foreach ($gurus as $guru)

                        <option
                            value="{{ $guru->id }}"
                            {{ $data->guru_pembina_id == $guru->id ? 'selected' : '' }}>

                            {{ $guru->nama }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- PEMBINAAN --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Pembinaan
                </label>

                <textarea
                    name="pembinaan"
                    rows="3"
                    class="w-full border rounded px-3 py-2">{{ old('pembinaan', $data->pembinaan) }}</textarea>

            </div>


            {{-- PARAF GURU --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Paraf Guru
                </label>

                <input
                    type="file"
                    name="paraf_guru"
                    class="w-full border rounded px-3 py-2">

                <p class="text-xs text-gray-500 mt-1">
                    Kosongkan jika tidak ingin mengganti file.
                </p>


                @if($data->paraf_guru)

                    <a
                        href="{{ asset('storage/'.$data->paraf_guru) }}"
                        target="_blank"
                        class="text-blue-600 text-sm mt-2 inline-block">

                        Lihat File Saat Ini

                    </a>

                @endif

            </div>


        </div>


        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 mt-6">

            <a
                href="{{ route('piket.perizinan.terlambat.index') }}"
                class="px-4 py-2 border rounded">

                Batal

            </a>


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                Update

            </button>

        </div>


    </form>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT SISWA --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const kelasSelect = document.getElementById('kelas_id');
    const siswaSelect = document.getElementById('siswa_select');

    const namaInput = document.getElementById('nama_siswa');
    const nisInput = document.getElementById('nis');


    // Simpan semua siswa dari Master Data
    const semuaSiswa = Array.from(
        siswaSelect.querySelectorAll('option')
    ).filter(function (option) {

        return option.value !== '';

    });


    // Filter siswa berdasarkan kelas
    function filterSiswa(kelasId, selectedNis = null) {

        siswaSelect.innerHTML = '';


        const defaultOption = document.createElement('option');

        defaultOption.value = '';
        defaultOption.textContent = '-- Pilih Siswa --';

        siswaSelect.appendChild(defaultOption);


        if (!kelasId) {

            siswaSelect.disabled = true;

            return;

        }


        let siswaTerpilih = null;


        semuaSiswa.forEach(function (option) {

            if (option.dataset.kelas === kelasId) {

                const clone = option.cloneNode(true);


                if (
                    selectedNis &&
                    option.dataset.nis === selectedNis
                ) {

                    clone.selected = true;

                    siswaTerpilih = option;

                }


                siswaSelect.appendChild(clone);

            }

        });


        siswaSelect.disabled = false;


        // Isi nama dan NIS siswa yang sedang diedit
        if (siswaTerpilih) {

            namaInput.value =
                siswaTerpilih.dataset.nama || '';

            nisInput.value =
                siswaTerpilih.dataset.nis || '';

        }

    }


    // Ketika kelas berubah
    kelasSelect.addEventListener('change', function () {

        const kelasId = this.value;


        filterSiswa(kelasId);


        namaInput.value = '';
        nisInput.value = '';

    });


    // Ketika siswa dipilih
    siswaSelect.addEventListener('change', function () {

        const selectedOption =
            this.options[this.selectedIndex];


        if (!this.value) {

            namaInput.value = '';
            nisInput.value = '';

            return;

        }


        namaInput.value =
            selectedOption.dataset.nama || '';

        nisInput.value =
            selectedOption.dataset.nis || '';

    });


    // Jalankan saat halaman pertama kali dibuka
    const kelasAwal = kelasSelect.value;
    const nisAwal = "{{ old('nis', $data->nis) }}";


    if (kelasAwal) {

        filterSiswa(kelasAwal, nisAwal);

    }

});

</script>

@endsection