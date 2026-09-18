@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <h2 class="text-2xl font-semibold mb-6">
        Tambah Jurnal KBM
    </h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('guru.jurnals.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6 space-y-5">

        @csrf

        {{-- PILIH JADWAL --}}
        <div>
            <label class="block text-sm font-medium mb-2">
                Pilih Jadwal Mengajar
            </label>

            <select name="jadwal_id"
                    id="jadwalSelect"
                    class="w-full border rounded px-3 py-2"
                    required>

                <option value="">-- Pilih Jadwal --</option>

                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id }}"
                        data-kelas="{{ $jadwal->kelas->nama }}"
                        data-mapel="{{ $jadwal->mapel->nama }}"
                        data-ruangan="{{ $jadwal->ruangan->nama ?? '-' }}"
                        data-jam="{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}">
                        {{ ucfirst($jadwal->hari) }} | Jam {{ $jadwal->jam_ke }} | {{ $jadwal->kelas->nama }} | {{ $jadwal->mapel->nama }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- TANGGAL --}}
        <div>
            <label class="block text-sm font-medium">Tanggal KBM</label>
            <input type="date"
                   name="tanggal_kbm"
                   value="{{ now()->format('Y-m-d') }}"
                   class="mt-1 w-full border rounded px-3 py-2"
                   required>
        </div>

        {{-- KELAS --}}
        <div>
            <label class="block text-sm font-medium">Kelas</label>
            <input type="text"
                   id="kelasField"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- PJJ / DARING --}}
        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox"
                    name="is_daring"
                    id="isDaring"
                    value="1"
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
                class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                readonly>
        </div>


        {{-- METODE PJJ --}}
        <div id="metodePjjWrapper" class="hidden">

            <label class="block text-sm font-medium mb-2">
                Metode PJJ
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="wag"
                        class="metode-pjj w-4 h-4 rounded border-gray-300">

                    <span>WhatsApp Group (WAG)</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="google_meet"
                        class="metode-pjj w-4 h-4 rounded border-gray-300">

                    <span>Google Meet</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="zoom"
                        class="metode-pjj w-4 h-4 rounded border-gray-300">

                    <span>Zoom</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="google_classroom"
                        class="metode-pjj w-4 h-4 rounded border-gray-300">

                    <span>Google Classroom</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="lms"
                        class="metode-pjj w-4 h-4 rounded border-gray-300">

                    <span>LMS</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                        name="pjj_menggunakan[]"
                        value="lainnya"
                        id="metodeLainnya"
                        class="metode-pjj w-4 h-4 rounded border-gray-300">

                    <span>Lainnya</span>
                </label>

            </div>


            {{-- INPUT METODE LAINNYA --}}
            <div id="pjjLainnyaWrapper" class="hidden mt-4">

                <label class="block text-sm font-medium mb-1">
                    Metode PJJ Lainnya
                </label>

                <input type="text"
                    name="pjj_lainnya"
                    id="pjjLainnya"
                    value="{{ old('pjj_lainnya') }}"
                    class="w-full border rounded px-3 py-2"
                    placeholder="Masukkan metode PJJ lainnya">

            </div>

        </div>

        {{-- MAPEL --}}
        <div>
            <label class="block text-sm font-medium">Mata Pelajaran</label>
            <input type="text"
                   id="mapelField"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- JAM --}}
        <div>
            <label class="block text-sm font-medium">Jam Pelajaran</label>
            <input type="text"
                   id="jamField"
                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- MATERI --}}
        <div>
            <label class="block text-sm font-medium">Materi</label>
            <textarea name="materi"
                      rows="3"
                      class="mt-1 w-full border rounded px-3 py-2"
                      required>{{ old('materi') }}</textarea>
        </div>

        {{-- KEGIATAN --}}
        <div>
            <label class="block text-sm font-medium">Kegiatan</label>
            <textarea name="kegiatan"
                      rows="2"
                      class="mt-1 w-full border rounded px-3 py-2">{{ old('kegiatan') }}</textarea>
        </div>

        {{-- ABSENSI --}}
        <div class="border rounded-lg p-5 bg-gray-50">

            <div class="flex items-center justify-between mb-4">

                <div>
                    <h3 class="font-semibold text-gray-800">
                        Absensi Siswa
                    </h3>

                    <p class="text-sm text-gray-500">
                        Isi kehadiran masing-masing siswa.
                    </p>
                </div>

                <button
                    type="button"
                    id="btnAbsensi"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">

                    Isi Absensi

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
                        readonly
                        placeholder="Belum diisi"></textarea>
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
                        readonly
                        placeholder="Belum ada siswa izin"></textarea>
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
                        readonly
                        placeholder="Belum ada siswa sakit"></textarea>
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
                        readonly
                        placeholder="Belum ada siswa alfa"></textarea>
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
                        readonly
                        placeholder="Belum ada siswa PKL"></textarea>
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
                        readonly
                        placeholder="Belum ada siswa dispensasi"></textarea>
                </div>

            </div>

        </div>


        {{-- =====================================================
            MODAL ABSENSI
        ===================================================== --}}

        <div id="absensiModal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

            <div class="bg-white w-full max-w-6xl rounded-xl shadow-xl max-h-[90vh] flex flex-col">

                {{-- HEADER MODAL --}}
                <div class="flex items-center justify-between px-6 py-4 border-b">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Isi Absensi Siswa
                        </h3>

                        <p class="text-sm text-gray-500">
                            Tentukan status dan alasan masing-masing siswa.
                        </p>
                    </div>

                    <button
                        type="button"
                        id="btnCloseAbsensi"
                        class="text-gray-500 hover:text-gray-800 text-2xl">

                        &times;

                    </button>

                </div>


                {{-- BODY MODAL --}}
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


                {{-- FOOTER MODAL --}}
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
            <label class="block text-sm font-medium">Dokumentasi Kegiatan</label>
            <input type="file"
                   name="foto"
                   accept="image/*"
                   capture="environment"
                   class="mt-1 w-full border rounded px-3 py-2">
        </div>

        {{-- FILE IZIN --}}
        <div>
            <label class="block text-sm font-medium">Upload Surat Izin Guru (Opsional)</label>
            <input type="file"
                   name="file_izin_guru"
                   class="mt-1 w-full border rounded px-3 py-2">
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-4">

            <a href="{{ route('guru.jurnals.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Simpan
            </button>

        </div>

    </form>

</div>


<script>

const jadwalSelect = document.getElementById('jadwalSelect');

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


// PJJ ON / OFF
isDaring.addEventListener('change', function () {

    if (this.checked) {

        // Disable ruangan
        ruanganField.disabled = true;
        ruanganField.classList.add('bg-gray-200', 'text-gray-500');

        // Tampilkan metode PJJ
        metodePjjWrapper.classList.remove('hidden');

    } else {

        // Aktifkan kembali ruangan
        ruanganField.disabled = false;
        ruanganField.classList.remove('bg-gray-200', 'text-gray-500');

        // Sembunyikan metode PJJ
        metodePjjWrapper.classList.add('hidden');

        // Reset pilihan metode
        document.querySelectorAll('.metode-pjj').forEach(function (checkbox) {
            checkbox.checked = false;
        });

        // Reset lainnya
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
// PILIH JADWAL
// =====================================================

jadwalSelect.addEventListener('change', function () {

    const selected = this.options[this.selectedIndex];

    document.getElementById('kelasField').value =
        selected.dataset.kelas || '';

    document.getElementById('mapelField').value =
        selected.dataset.mapel || '';

    document.getElementById('ruanganField').value =
        selected.dataset.ruangan || '';

    document.getElementById('jamField').value =
        selected.dataset.jam || '';


    // Reset ringkasan absensi
    resetSummary();

});


// =====================================================
// BUKA MODAL ABSENSI
// =====================================================

btnAbsensi.addEventListener('click', function () {

    const jadwalId = jadwalSelect.value;

    if (!jadwalId) {

        alert('Silakan pilih jadwal mengajar terlebih dahulu.');

        return;
    }


    absensiModal.classList.remove('hidden');


    absensiBody.innerHTML = `
        <tr>
            <td colspan="5"
                class="px-4 py-8 text-center text-gray-400">

                Memuat data siswa...

            </td>
        </tr>
    `;


    fetch(`{{ url('/guru/jurnals/siswa') }}/${jadwalId}`)

        .then(response => {

            if (!response.ok) {
                throw new Error('Gagal mengambil data siswa.');
            }

            return response.json();

        })

        .then(siswa => {

            if (siswa.length === 0) {

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


            absensiBody.innerHTML = siswa.map((item, index) => {

                return `
                    <tr class="border-b hover:bg-gray-50">

                        <!-- NO -->
                        <td class="px-4 py-3">
                            ${index + 1}
                        </td>


                        <!-- NIS -->
                        <td class="px-4 py-3">
                            ${item.nis}
                        </td>


                        <!-- NAMA -->
                        <td class="px-4 py-3 font-medium">
                            ${item.nama}
                        </td>


                        <!-- STATUS -->
                        <td class="px-4 py-3">

                            <select
                                name="absensi[${item.id}][status]"
                                class="w-full border rounded px-3 py-2 status-absensi">

                                <option value="hadir" selected>
                                    Hadir
                                </option>

                                <option value="izin">
                                    Izin
                                </option>

                                <option value="sakit">
                                    Sakit
                                </option>

                                <option value="alfa">
                                    Alfa
                                </option>

                                <option value="pkl">
                                    PKL
                                </option>

                                <option value="dispensasi">
                                    Dispensasi
                                </option>

                            </select>

                        </td>


                        <!-- ALASAN -->
                        <td class="px-4 py-3">

                            <input
                                type="text"
                                name="absensi[${item.id}][alasan]"
                                class="w-full border rounded px-3 py-2 alasan-absensi"
                                placeholder="Alasan / keterangan"
                                disabled>

                        </td>

                    </tr>
                `;

            }).join('');


            // =================================================
            // STATUS → ALASAN
            // =================================================

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

                        } else {

                            alasan.disabled = false;

                            alasan.required = true;

                        }

                    });

                });

        })

        .catch(error => {

            console.error(error);

            absensiBody.innerHTML = `
                <tr>
                    <td colspan="5"
                        class="px-4 py-8 text-center text-red-500">

                        Gagal mengambil data siswa.

                    </td>
                </tr>
            `;

        });

});


// =====================================================
// SIMPAN ABSENSI DARI MODAL
// =====================================================

btnSimpanAbsensi.addEventListener('click', function () {

    const rows = absensiBody.querySelectorAll('tr');

    if (rows.length === 0) {

        alert('Data siswa belum tersedia.');

        return;
    }


    const dataAbsensi = {

        hadir: [],
        izin: [],
        sakit: [],
        alfa: [],
        pkl: [],
        dispensasi: []

    };


    let valid = true;


    rows.forEach(row => {

        const status = row.querySelector('.status-absensi');

        const alasan = row.querySelector('.alasan-absensi');

        const nama = row.children[2]?.textContent.trim();


        if (!status) {
            return;
        }


        // Cek alasan untuk selain Hadir
        if (
            status.value !== 'hadir' &&
            !alasan.value.trim()
        ) {

            valid = false;

            alasan.classList.add('border-red-500');

        } else {

            alasan.classList.remove('border-red-500');

        }


        dataAbsensi[status.value].push({

            nama: nama,
            alasan: alasan.value.trim()

        });

    });


    if (!valid) {

        alert('Silakan isi alasan/keterangan untuk siswa yang tidak hadir.');

        return;
    }


    // =================================================
    // MASUKKAN KE TEXTBOX / RINGKASAN
    // =================================================

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


    // Tutup modal
    absensiModal.classList.add('hidden');

});


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
// RESET ABSENSI
// =====================================================

function resetSummary() {

    document.getElementById('summaryHadir').value = '';

    document.getElementById('summaryIzin').value = '';

    document.getElementById('summarySakit').value = '';

    document.getElementById('summaryAlfa').value = '';

    document.getElementById('summaryPkl').value = '';

    document.getElementById('summaryDispensasi').value = '';

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