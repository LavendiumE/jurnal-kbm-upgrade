@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">
            Tambah Jurnal Guru Piket
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Pilih kelas, hari, dan jam pelajaran untuk mengambil data jadwal otomatis
        </p>
    </div>

    <form action="{{ route('piket.jurnal.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="bg-white border rounded-lg p-6 space-y-6">

            {{-- KELAS --}}
            <div>
                <label class="block text-sm font-medium mb-2">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- HARI --}}
            <div>
                <label class="block text-sm font-medium mb-2">Hari</label>
                <select name="hari" id="hari" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Hari --</option>
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                    <option value="kamis">Kamis</option>
                    <option value="jumat">Jumat</option>
                    <option value="sabtu">Sabtu</option>
                </select>
            </div>

            {{-- JAM --}}
            <div>
                <label class="block text-sm font-medium mb-2">Jam Ke</label>
                <select name="jam_ke" id="jam_ke" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Jam --</option>
                    @for($i=1; $i<=10; $i++)
                        <option value="{{ $i }}">Jam ke-{{ $i }}</option>
                    @endfor
                </select>
            </div>

            {{-- INFO OTOMATIS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-2">Mata Pelajaran</label>
                    <input type="text" id="mapel" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Guru Pengajar</label>
                    <input type="text" id="guru" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Ruangan</label>
                    <input type="text" id="ruangan" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

            </div>

            {{-- FOTO --}}
            <div>
                <label class="block text-sm font-medium mb-2">Upload Bukti Foto</label>
                <input 
                type="file" 
                name="foto" 
                accept="image/*"
                capture="environment"
                class="w-full border rounded px-3 py-2">
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('piket.jurnal.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded">
                Simpan
            </button>
        </div>

    </form>

</div>

<script>
const jadwals = @json($jadwals);

console.log(jadwals);

const kelas = document.getElementById('kelas_id');
const hari = document.getElementById('hari');
const jam = document.getElementById('jam_ke');

const mapel = document.getElementById('mapel');
const guru = document.getElementById('guru');
const ruangan = document.getElementById('ruangan');

function isiJadwal() {

    console.log({
        kelas: kelas.value,
        hari: hari.value,
        jam: jam.value
    });

    const selected = jadwals.find(j =>
        j.kelas_id == kelas.value &&
        j.hari == hari.value &&
        j.jam_ke == jam.value
    );

    console.log(selected);

    if (!selected) {

        mapel.value = 'Jadwal tidak ditemukan';
        guru.value = 'Jadwal tidak ditemukan';
        ruangan.value = 'Jadwal tidak ditemukan';

        console.warn('Tidak ada jadwal yang cocok', {
            kelas: kelas.value,
            hari: hari.value,
            jam: jam.value
        });

        return;
    }

    mapel.value = selected.mapel?.nama ?? '';
    guru.value = selected.guru?.nama ?? '';
    ruangan.value = selected.ruangan?.nama ?? '';
}

kelas.addEventListener('change', isiJadwal);
hari.addEventListener('change', isiJadwal);
jam.addEventListener('change', isiJadwal);
</script>

@endsection