@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">

        <h1 class="text-2xl font-semibold text-gray-800">
            Izin Pulang Lebih Awal
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Catat siswa yang pulang sebelum jam sekolah selesai
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
        action="{{ route('piket.perizinan.pulang.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf


        <div class="bg-white border rounded-lg p-6 space-y-6 shadow-sm">


            {{-- KELAS --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Kelas
                </label>

                <select
                    id="kelas_id"
                    class="w-full border rounded px-3 py-2"
                    required>

                    <option value="">
                        -- Pilih Kelas --
                    </option>

                    @foreach ($kelas as $k)

                        <option
                            value="{{ $k->id }}"
                            data-nama="{{ $k->nama }}">

                            {{ $k->nama }}

                        </option>

                    @endforeach

                </select>


                {{-- Kelas yang dikirim ke controller --}}
                <input
                    type="hidden"
                    name="kelas"
                    id="kelas"
                    value="">

            </div>


            {{-- NAMA SISWA --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Nama Siswa
                </label>

                <select
                    id="siswa_select"
                    class="w-full border rounded px-3 py-2"
                    required
                    disabled>

                    <option value="">
                        -- Pilih kelas terlebih dahulu --
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
                    name="nama"
                    id="nama"
                    value="">

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
                    value="{{ date('Y-m-d') }}"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    readonly>

            </div>


            {{-- ALASAN --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Alasan
                </label>

                <textarea
                    name="keperluan"
                    rows="3"
                    class="w-full border rounded px-3 py-2"
                    placeholder="Tuliskan alasan pulang lebih awal"
                    required></textarea>

            </div>


            {{-- JAM PULANG --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Jam Pulang
                </label>

                <input
                    type="time"
                    name="jam_izin"
                    class="w-full border rounded px-3 py-2"
                    required>

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
                    Upload tanda tangan / bukti izin guru.
                </p>

            </div>


        </div>


        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 mt-6">

            <a
                href="{{ route('piket.perizinan.pulang.index') }}"
                class="px-4 py-2 border rounded">

                Batal

            </a>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">

                Simpan

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

    const kelasInput = document.getElementById('kelas');
    const namaInput = document.getElementById('nama');
    const nisInput = document.getElementById('nis');


    // Simpan semua siswa dari Master Data
    const semuaSiswa = Array.from(
        siswaSelect.querySelectorAll('option')
    ).slice(1);


    // Ketika kelas dipilih
    kelasSelect.addEventListener('change', function () {

        const kelasId = this.value;

        const selectedKelas =
            this.options[this.selectedIndex];


        // Isi nama kelas yang dikirim ke controller
        kelasInput.value =
            selectedKelas.dataset.nama || '';


        // Reset siswa
        siswaSelect.innerHTML = '';

        namaInput.value = '';
        nisInput.value = '';


        if (!kelasId) {

            siswaSelect.disabled = true;

            const option = document.createElement('option');

            option.value = '';
            option.textContent = '-- Pilih kelas terlebih dahulu --';

            siswaSelect.appendChild(option);

            kelasInput.value = '';

            return;

        }


        // Option default
        const defaultOption = document.createElement('option');

        defaultOption.value = '';
        defaultOption.textContent = '-- Pilih Siswa --';

        siswaSelect.appendChild(defaultOption);


        // Filter siswa berdasarkan kelas
        semuaSiswa.forEach(function (option) {

            if (option.dataset.kelas === kelasId) {

                siswaSelect.appendChild(
                    option.cloneNode(true)
                );

            }

        });


        siswaSelect.disabled = false;

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

});

</script>

@endsection