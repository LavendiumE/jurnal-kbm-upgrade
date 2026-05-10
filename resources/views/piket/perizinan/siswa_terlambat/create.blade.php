@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Catatan Siswa Terlambat
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Input data siswa yang datang terlambat ke sekolah
        </p>
    </div>

    <form action="{{ route('piket.perizinan.terlambat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white border rounded-lg p-6 space-y-6 shadow-sm">

            <div>
                <label class="block text-sm font-medium mb-2">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">NIS</label>
                <input type="text" name="nis" class="w-full border rounded px-3 py-2" required>
            </div>

            
            {{-- Tanggal --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Tanggal
                </label>

                <input type="date"
                    name="tanggal"
                    value="{{ date('Y-m-d') }}"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    readonly>
            </div>
        


            <div>
                <label class="block text-sm font-medium mb-2">Kelas</label>
                <select name="kelas_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Jam Terlambat</label>
                <input type="time" name="jam_terlambat" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Cuaca</label>
                <input type="text" name="cuaca" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Alasan</label>
                <textarea name="alasan" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Guru Pembina</label>
                <select name="guru_pembina_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Pembinaan</label>
                <textarea name="pembinaan" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Paraf Guru</label>
                <input type="file"
                    name="paraf_guru"
                    class="w-full border rounded px-3 py-2">
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('piket.perizinan.terlambat.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-yellow-600 text-white px-6 py-2 rounded">
                Simpan
            </button>
        </div>

    </form>

</div>

@endsection