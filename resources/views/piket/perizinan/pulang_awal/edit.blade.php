```php id="e7f4a1"
@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Edit Izin Pulang Lebih Awal
        </h1>
    </div>

    <form action="{{ route('piket.perizinan.pulang.update', $izin->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white border rounded-lg p-6 space-y-6 shadow-sm">

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium mb-2">Nama Siswa</label>
                <input type="text"
                       name="nama"
                       value="{{ $izin->nama }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- NIS --}}
            <div>
                <label class="block text-sm font-medium mb-2">NIS</label>
                <input type="text"
                       name="nis"
                       value="{{ $izin->nis }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block text-sm font-medium mb-2">Tanggal</label>
                <input type="date"
                       name="tanggal"
                       value="{{ $izin->tanggal }}"
                       class="w-full border rounded px-3 py-2 bg-gray-100"
                       readonly>
            </div>

            {{-- Kelas --}}
            <div>
                <label class="block text-sm font-medium mb-2">Kelas</label>
                <select name="kelas"
                        class="w-full border rounded px-3 py-2">
                    @foreach ($kelas as $k)
                        <option value="{{ $k->nama }}"
                            {{ $izin->kelas == $k->nama ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Keperluan --}}
            <div>
                <label class="block text-sm font-medium mb-2">Alasan / Keperluan</label>
                <textarea name="keperluan"
                          rows="3"
                          class="w-full border rounded px-3 py-2">{{ $izin->keperluan }}</textarea>
            </div>

            {{-- Jam Pulang --}}
            <div>
                <label class="block text-sm font-medium mb-2">Jam Pulang</label>
                <input type="time"
                       name="jam_izin"
                       value="{{ $izin->jam_izin }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- Paraf Guru --}}
            <div>
                <label class="block text-sm font-medium mb-2">Paraf Guru</label>

                <input type="file"
                       name="paraf_guru"
                       class="w-full border rounded px-3 py-2">

                @if($izin->paraf_guru)
                    <div class="mt-3">
                        <img src="{{ asset('storage/'.$izin->paraf_guru) }}"
                             class="w-32 border rounded">
                    </div>
                @endif
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('piket.perizinan.pulang.index') }}"
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

@endsection
```
