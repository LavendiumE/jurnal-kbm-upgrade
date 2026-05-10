@extends('layouts.app')

@section('content')

<h2 class="text-lg font-semibold mb-4">
Dashboard Guru Mata Pelajaran
</h2>

@if($informasi)
<div class="bg-yellow-100 border border-yellow-300 rounded px-4 py-2 mb-4">
    <marquee behavior="scroll" direction="left">
        {{ $informasi->isi }}
    </marquee>
</div>
@endif

<div class="bg-white rounded shadow p-6">

<h3 class="text-gray-500 text-sm mb-3">
Tabel Jurnal
</h3>

<table class="w-full text-sm">

<thead class="bg-gray-50">

<tr>
<th class="p-2">Tanggal</th>
<th class="p-2">Jam</th>
<th class="p-2">Kelas</th>
<th class="p-2">Mapel</th>
<th class="p-2">Materi</th>
<th class="p-2">Aksi</th>
</tr>

</thead>

<tbody>

@foreach($jurnals as $jurnal)

<tr class="border-t">

<td class="p-2">{{ $jurnal->tanggal }}</td>
<td class="p-2">{{ $jurnal->jam_mulai }}</td>
<td class="p-2">{{ $jurnal->kelas }}</td>
<td class="p-2">{{ $jurnal->mapel }}</td>
<td class="p-2">{{ $jurnal->materi }}</td>

<td class="p-2">

<a href="/jurnal/{{ $jurnal->id }}/edit"
class="text-blue-600">Edit</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection