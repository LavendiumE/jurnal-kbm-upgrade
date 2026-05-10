@extends('layouts.app')

@section('content')

<div class="sm:ml-64 pt-20 px-6 pb-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Data Ruangan</h2>

        <button onclick="openModal('modalRuangan')"
                class="bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Ruangan
        </button>
    </div>

    <div class="bg-white border rounded-lg overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Ruangan</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $item)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $item->nama }}</td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('admin.ruangans.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

<div id="modalRuangan" class="hidden fixed inset-0 bg-black/30 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-md">

        <h3 class="text-lg font-semibold mb-4">Tambah Ruangan</h3>

        <form action="{{ route('admin.ruangans.store') }}" method="POST">
            @csrf

            <input type="text"
                   name="nama"
                   class="w-full border rounded px-3 py-2 mb-4"
                   placeholder="Nama Ruangan">

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeModal('modalRuangan')"
                        class="px-4 py-2 border rounded">
                    Batal
                </button>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<script>
function openModal(id){
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id){
    document.getElementById(id).classList.add('hidden');
}
</script>

@endsection

