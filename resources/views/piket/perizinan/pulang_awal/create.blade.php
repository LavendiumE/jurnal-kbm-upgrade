@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Izin Pulang Lebih Awal
        </h1>
    </div>

    <form action="{{ route('piket.perizinan.pulang.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="bg-white border rounded-lg p-6 space-y-6 shadow-sm">

            <div>
                <label class="block text-sm font-medium mb-2">Nama Siswa</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
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
                <select name="kelas" class="w-full border rounded px-3 py-2" required>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Alasan</label>
                <textarea name="keperluan" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Jam Pulang</label>
                <input type="time" name="jam_izin" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Paraf Guru</label>
                <input type="file" name="paraf_guru" class="w-full border rounded px-3 py-2">
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('piket.perizinan.pulang.index') }}" class="px-4 py-2 border rounded">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Simpan</button>
        </div>

    </form>

</div>

@endsection