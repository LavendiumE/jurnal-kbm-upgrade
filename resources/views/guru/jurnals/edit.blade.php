@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <h2 class="text-2xl font-semibold mb-6">
        Edit Jurnal KBM
    </h2>

    <form action="{{ route('guru.jurnals.update', $jurnal->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6 space-y-5">

        @csrf
        @method('PUT')

        {{-- TANGGAL --}}
        <div>
            <label class="block text-sm font-medium">Tanggal KBM</label>
            <input type="date"
                   value="{{ $jurnal->created_at->format('Y-m-d') }}"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- KELAS --}}
        <div>
            <label class="block text-sm font-medium">Kelas</label>
            <input type="text"
                   value="{{ $jurnal->kelas->nama ?? '-' }}"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- RUANGAN --}}
        {{-- PJJ / DARING --}}
        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox"
                    name="is_daring"
                    id="isDaring"
                    value="1"
                    {{ $jurnal->is_daring ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-gray-300">

                <span class="text-sm font-medium">
                    PJJ / Daring
                </span>
            </label>
        </div>


        {{-- RUANGAN --}}
        <div>
            <label class="block text-sm font-medium">
                Ruangan
            </label>

            <input type="text"
                id="ruanganField"
                value="{{ $jurnal->jadwal->ruangan->nama ?? '-' }}"
                class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                readonly>
        </div>


        {{-- METODE PJJ --}}
        <div id="metodePjjWrapper"
            class="{{ $jurnal->is_daring ? '' : 'hidden' }}">

            <label class="block text-sm font-medium mb-2">
                Metode PJJ
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="wag"
                        class="metode-pjj w-4 h-4 rounded border-gray-300"
                        {{ in_array('wag', $jurnal->pjj_menggunakan ?? []) ? 'checked' : '' }}>

                    <span>WhatsApp Group (WAG)</span>
                </label>


                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="google_meet"
                        class="metode-pjj w-4 h-4 rounded border-gray-300"
                        {{ in_array('google_meet', $jurnal->pjj_menggunakan ?? []) ? 'checked' : '' }}>

                    <span>Google Meet</span>
                </label>


                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="zoom"
                        class="metode-pjj w-4 h-4 rounded border-gray-300"
                        {{ in_array('zoom', $jurnal->pjj_menggunakan ?? []) ? 'checked' : '' }}>

                    <span>Zoom</span>
                </label>


                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="google_classroom"
                        class="metode-pjj w-4 h-4 rounded border-gray-300"
                        {{ in_array('google_classroom', $jurnal->pjj_menggunakan ?? []) ? 'checked' : '' }}>

                    <span>Google Classroom</span>
                </label>


                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="lms"
                        class="metode-pjj w-4 h-4 rounded border-gray-300"
                        {{ in_array('lms', $jurnal->pjj_menggunakan ?? []) ? 'checked' : '' }}>

                    <span>LMS</span>
                </label>


                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="lainnya"
                        id="metodeLainnya"
                        class="metode-pjj w-4 h-4 rounded border-gray-300"
                        {{ in_array('lainnya', $jurnal->pjj_menggunakan ?? []) ? 'checked' : '' }}>

                    <span>Lainnya</span>
                </label>

            </div>


            {{-- INPUT METODE LAINNYA --}}
            <div id="pjjLainnyaWrapper"
                class="{{ in_array('lainnya', $jurnal->pjj_menggunakan ?? []) ? '' : 'hidden' }} mt-4">

                <label class="block text-sm font-medium mb-1">
                    Metode PJJ Lainnya
                </label>

                <input type="text"
                    name="pjj_lainnya"
                    id="pjjLainnya"
                    value="{{ old('pjj_lainnya', $jurnal->pjj_lainnya) }}"
                    class="w-full border rounded px-3 py-2"
                    placeholder="Masukkan metode PJJ lainnya"
                    {{ in_array('lainnya', $jurnal->pjj_menggunakan ?? []) ? 'required' : '' }}>

            </div>

        </div>

        {{-- MAPEL --}}
        <div>
            <label class="block text-sm font-medium">Mata Pelajaran</label>
            <input type="text"
                   value="{{ $jurnal->jadwal->mapel->nama ?? '-' }}"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- JAM --}}
        <div>
            <label class="block text-sm font-medium">Jam Pelajaran</label>
            <input type="text"
                   value="{{ $jurnal->jadwal->jam_mulai ?? '-' }} - {{ $jurnal->jadwal->jam_selesai ?? '-' }}"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- MATERI --}}
        <div>
            <label class="block text-sm font-medium">Materi</label>
            <textarea name="materi"
                      rows="3"
                      class="mt-1 w-full border rounded px-3 py-2"
                      required>{{ $jurnal->materi }}</textarea>
        </div>

        {{-- KEGIATAN --}}
        <div>
            <label class="block text-sm font-medium">Kegiatan</label>
            <textarea name="kegiatan"
                      rows="2"
                      class="mt-1 w-full border rounded px-3 py-2">{{ $jurnal->kegiatan }}</textarea>
        </div>

        {{-- ABSENSI --}}
        <div class="border rounded-lg p-5 bg-gray-50">

            <div class="flex items-center justify-between mb-4">

                <div>
                    <h3 class="font-semibold text-gray-800">
                        Absensi Siswa
                    </h3>

                    <p class="text-sm text-gray-500">
                        Edit kehadiran masing-masing siswa.
                    </p>
                </div>

                <button
                    type="button"
                    id="btnAbsensi"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">

                    Edit Absensi

                </button>

            </div>


            {{-- RINGKASAN ABSENSI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- HADIR --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Hadir
                    </label>

                    <textarea
                        id="summaryHadir"
                        rows="2"
                        class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly></textarea>
                </div>


                {{-- IZIN --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Izin
                    </label>

                    <textarea
                        id="summaryIzin"
                        rows="2"
                        class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly></textarea>
                </div>


                {{-- SAKIT --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Sakit
                    </label>

                    <textarea
                        id="summarySakit"
                        rows="2"
                        class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly></textarea>
                </div>


                {{-- ALFA --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Alfa
                    </label>

                    <textarea
                        id="summaryAlfa"
                        rows="2"
                        class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly></textarea>
                </div>


                {{-- PKL --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        PKL
                    </label>

                    <textarea
                        id="summaryPkl"
                        rows="2"
                        class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly></textarea>
                </div>


                {{-- DISPENSASI --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Dispensasi
                    </label>

                    <textarea
                        id="summaryDispensasi"
                        rows="2"
                        class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly></textarea>
                </div>

            </div>

        </div>


        {{-- =====================================================
            MODAL ABSENSI
        ===================================================== --}}

        <div id="absensiModal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

            <div class="bg-white w-full max-w-6xl rounded-xl shadow-xl max-h-[90vh] flex flex-col">

                {{-- HEADER --}}
                <div class="flex items-center justify-between px-6 py-4 border-b">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Edit Absensi Siswa
                        </h3>

                        <p class="text-sm text-gray-500">
                            Perbarui status dan alasan masing-masing siswa.
                        </p>
                    </div>

                    <button
                        type="button"
                        id="btnCloseAbsensi"
                        class="text-gray-500 hover:text-gray-800 text-2xl">

                        &times;

                    </button>

                </div>


                {{-- BODY --}}
                <div class="p-6 overflow-y-auto">

                    <div class="overflow-x-auto border rounded-lg">

                        <table class="w-full text-sm">

                            <thead class="bg-gray-100 sticky top-0">

                                <tr>

                                    <th class="px-4 py-3 text-left">
                                        No
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        NIS
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Nama Siswa
                                    </th>

                                    <th class="px-4 py-3 text-center">
                                        Status
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Alasan / Keterangan
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="absensiBody">

                                {{-- Diisi Javascript --}}

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50 rounded-b-xl">

                    <button
                        type="button"
                        id="btnBatalAbsensi"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">

                        Batal

                    </button>

                    <button
                        type="button"
                        id="btnSimpanAbsensi"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">

                        Simpan Absensi

                    </button>

                </div>

            </div>

        </div>

        {{-- FOTO --}}
        <div>
            <label class="block text-sm font-medium mb-1">
                Dokumentasi Kegiatan
            </label>

            @if ($jurnal->foto)
                <img src="{{ asset('storage/'.$jurnal->foto) }}"
                     class="w-40 rounded mb-2 border">
            @endif

            <input type="file"
                   name="foto"
                   accept="image/*"
                   capture="environment"
                   class="mt-1 w-full border rounded px-3 py-2">
        </div>

        {{-- FILE IZIN --}}
        <div>
            <label class="block text-sm font-medium mb-1">
                Surat Izin Guru
            </label>

            @if($jurnal->file_izin_guru)
                <a href="{{ asset('storage/'.$jurnal->file_izin_guru) }}"
                   target="_blank"
                   class="text-blue-600 text-sm underline block mb-2">
                    Lihat file saat ini
                </a>
            @endif

            <input type="file"
                   name="file_izin_guru"
                   class="mt-1 w-full border rounded px-3 py-2">
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3">

            <a href="{{ route('guru.jurnals.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Update
            </button>

        </div>

    </form>

</div>

<script>

const btnAbsensi = document.getElementById('btnAbsensi');

const absensiModal = document.getElementById('absensiModal');

const btnCloseAbsensi = document.getElementById('btnCloseAbsensi');

const btnBatalAbsensi = document.getElementById('btnBatalAbsensi');

const btnSimpanAbsensi = document.getElementById('btnSimpanAbsensi');

const absensiBody = document.getElementById('absensiBody');

// =====================================================
// PJJ / DARING
// =====================================================

const isDaring = document.getElementById('isDaring');
const ruanganField = document.getElementById('ruanganField');
const metodePjjWrapper = document.getElementById('metodePjjWrapper');
const metodeLainnya = document.getElementById('metodeLainnya');
const pjjLainnyaWrapper = document.getElementById('pjjLainnyaWrapper');
const pjjLainnya = document.getElementById('pjjLainnya');


// Kondisi awal saat halaman Edit dibuka
if (isDaring.checked) {
    ruanganField.disabled = true;
    ruanganField.classList.add('bg-gray-200', 'text-gray-500');
} else {
    ruanganField.disabled = false;
}


// PJJ ON / OFF
isDaring.addEventListener('change', function () {

    if (this.checked) {

        ruanganField.disabled = true;
        ruanganField.classList.add('bg-gray-200', 'text-gray-500');

        metodePjjWrapper.classList.remove('hidden');

    } else {

        ruanganField.disabled = false;
        ruanganField.classList.remove('bg-gray-200', 'text-gray-500');

        metodePjjWrapper.classList.add('hidden');

        document.querySelectorAll('.metode-pjj').forEach(function (checkbox) {
            checkbox.checked = false;
        });

        pjjLainnyaWrapper.classList.add('hidden');
        pjjLainnya.value = '';
        pjjLainnya.required = false;
    }

});


// Lainnya
metodeLainnya.addEventListener('change', function () {

    if (this.checked) {

        pjjLainnyaWrapper.classList.remove('hidden');
        pjjLainnya.required = true;

    } else {

        pjjLainnyaWrapper.classList.add('hidden');
        pjjLainnya.value = '';
        pjjLainnya.required = false;
    }

});


// =====================================================
// DATA ABSENSI LAMA
// =====================================================

const absensiLama = @json(
    $jurnal->absensis->keyBy('siswa_id')
);


// =====================================================
// DATA SISWA
// =====================================================

const siswaList = @json(
    $jurnal->kelas->siswa
);


// =====================================================
// RINGKASAN AWAL
// =====================================================

document.addEventListener('DOMContentLoaded', function () {

    buatRingkasanAwal();

});


// =====================================================
// BUKA MODAL ABSENSI
// =====================================================

btnAbsensi.addEventListener('click', function () {

    absensiModal.classList.remove('hidden');

    tampilkanSiswa();

});


// =====================================================
// TAMPILKAN SISWA
// =====================================================

function tampilkanSiswa() {

    if (siswaList.length === 0) {

        absensiBody.innerHTML = `
            <tr>
                <td colspan="5"
                    class="px-4 py-8 text-center text-gray-400">

                    Belum ada data siswa pada kelas ini.

                </td>
            </tr>
        `;

        return;
    }


    absensiBody.innerHTML = siswaList.map((siswa, index) => {

        const absensi = absensiLama[siswa.id];

        const status = absensi
            ? absensi.status
            : 'hadir';

        const alasan = absensi
            ? (absensi.alasan ?? '')
            : '';


        return `
            <tr class="border-b hover:bg-gray-50">

                <!-- NO -->
                <td class="px-4 py-3">
                    ${index + 1}
                </td>


                <!-- NIS -->
                <td class="px-4 py-3">
                    ${siswa.nis}
                </td>


                <!-- NAMA -->
                <td class="px-4 py-3 font-medium">
                    ${siswa.nama}
                </td>


                <!-- STATUS -->
                <td class="px-4 py-3">

                    <select
                        name="absensi[${siswa.id}][status]"
                        class="w-full border rounded px-3 py-2 status-absensi">

                        <option value="hadir"
                            ${status === 'hadir' ? 'selected' : ''}>
                            Hadir
                        </option>

                        <option value="izin"
                            ${status === 'izin' ? 'selected' : ''}>
                            Izin
                        </option>

                        <option value="sakit"
                            ${status === 'sakit' ? 'selected' : ''}>
                            Sakit
                        </option>

                        <option value="alfa"
                            ${status === 'alfa' ? 'selected' : ''}>
                            Alfa
                        </option>

                        <option value="pkl"
                            ${status === 'pkl' ? 'selected' : ''}>
                            PKL
                        </option>

                        <option value="dispensasi"
                            ${status === 'dispensasi' ? 'selected' : ''}>
                            Dispensasi
                        </option>

                    </select>

                </td>


                <!-- ALASAN -->
                <td class="px-4 py-3">

                    <input
                        type="text"
                        name="absensi[${siswa.id}][alasan]"
                        value="${escapeHtml(alasan)}"
                        class="w-full border rounded px-3 py-2 alasan-absensi"
                        placeholder="Alasan / keterangan"
                        ${status === 'hadir' ? 'disabled' : ''}
                        ${status !== 'hadir' ? 'required' : ''}>

                </td>

            </tr>
        `;

    }).join('');


    aktifkanStatusListener();

}


// =====================================================
// STATUS → ALASAN
// =====================================================

function aktifkanStatusListener() {

    document
        .querySelectorAll('.status-absensi')
        .forEach(select => {

            select.addEventListener('change', function () {

                const row = this.closest('tr');

                const alasan =
                    row.querySelector('.alasan-absensi');


                if (this.value === 'hadir') {

                    alasan.value = '';

                    alasan.disabled = true;

                    alasan.required = false;

                    alasan.classList.remove(
                        'border-red-500'
                    );

                } else {

                    alasan.disabled = false;

                    alasan.required = true;

                }

            });

        });

}


// =====================================================
// SIMPAN ABSENSI
// =====================================================

btnSimpanAbsensi.addEventListener('click', function () {

    const rows =
        absensiBody.querySelectorAll('tr');


    if (rows.length === 0) {

        alert('Data siswa belum tersedia.');

        return;

    }


    let valid = true;


    rows.forEach(row => {

        const status =
            row.querySelector('.status-absensi');

        const alasan =
            row.querySelector('.alasan-absensi');


        if (!status) {
            return;
        }


        if (
            status.value !== 'hadir' &&
            !alasan.value.trim()
        ) {

            valid = false;

            alasan.classList.add(
                'border-red-500'
            );

        } else {

            alasan.classList.remove(
                'border-red-500'
            );

        }

    });


    if (!valid) {

        alert(
            'Silakan isi alasan/keterangan untuk siswa yang tidak hadir.'
        );

        return;

    }


    // Update ringkasan
    updateSummary();


    // Tutup modal
    absensiModal.classList.add('hidden');

});


// =====================================================
// UPDATE RINGKASAN
// =====================================================

function updateSummary() {

    const dataAbsensi = {

        hadir: [],
        izin: [],
        sakit: [],
        alfa: [],
        pkl: [],
        dispensasi: []

    };


    const rows =
        absensiBody.querySelectorAll('tr');


    rows.forEach(row => {

        const status =
            row.querySelector('.status-absensi');

        const alasan =
            row.querySelector('.alasan-absensi');

        if (!status) {
            return;
        }


        const nama =
            row.children[2].textContent.trim();


        dataAbsensi[status.value].push({

            nama: nama,

            alasan: alasan.value.trim()

        });

    });


    document.getElementById('summaryHadir').value =
        buatRingkasan(dataAbsensi.hadir);

    document.getElementById('summaryIzin').value =
        buatRingkasan(dataAbsensi.izin);

    document.getElementById('summarySakit').value =
        buatRingkasan(dataAbsensi.sakit);

    document.getElementById('summaryAlfa').value =
        buatRingkasan(dataAbsensi.alfa);

    document.getElementById('summaryPkl').value =
        buatRingkasan(dataAbsensi.pkl);

    document.getElementById('summaryDispensasi').value =
        buatRingkasan(dataAbsensi.dispensasi);

}


// =====================================================
// RINGKASAN AWAL DARI DATABASE
// =====================================================

function buatRingkasanAwal() {

    const dataAbsensi = {

        hadir: [],
        izin: [],
        sakit: [],
        alfa: [],
        pkl: [],
        dispensasi: []

    };


    siswaList.forEach(siswa => {

        const absensi =
            absensiLama[siswa.id];


        if (!absensi) {

            dataAbsensi.hadir.push({

                nama: siswa.nama,

                alasan: ''

            });

            return;

        }


        dataAbsensi[absensi.status].push({

            nama: siswa.nama,

            alasan: absensi.alasan ?? ''

        });

    });


    document.getElementById('summaryHadir').value =
        buatRingkasan(dataAbsensi.hadir);

    document.getElementById('summaryIzin').value =
        buatRingkasan(dataAbsensi.izin);

    document.getElementById('summarySakit').value =
        buatRingkasan(dataAbsensi.sakit);

    document.getElementById('summaryAlfa').value =
        buatRingkasan(dataAbsensi.alfa);

    document.getElementById('summaryPkl').value =
        buatRingkasan(dataAbsensi.pkl);

    document.getElementById('summaryDispensasi').value =
        buatRingkasan(dataAbsensi.dispensasi);

}


// =====================================================
// BUAT RINGKASAN
// =====================================================

function buatRingkasan(data) {

    if (data.length === 0) {

        return '';

    }


    return data.map(item => {

        if (item.alasan) {

            return `${item.nama} - ${item.alasan}`;

        }

        return item.nama;

    }).join(', ');

}


// =====================================================
// ESCAPE HTML
// =====================================================

function escapeHtml(value) {

    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

}


// =====================================================
// TUTUP MODAL
// =====================================================

function tutupModalAbsensi() {

    absensiModal.classList.add('hidden');

}


btnCloseAbsensi.addEventListener(
    'click',
    tutupModalAbsensi
);


btnBatalAbsensi.addEventListener(
    'click',
    tutupModalAbsensi
);


// Klik area luar modal
absensiModal.addEventListener('click', function (event) {

    if (event.target === absensiModal) {

        tutupModalAbsensi();

    }

});

</script>

@endsection