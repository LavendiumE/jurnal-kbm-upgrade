<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Jurnal KBM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">

<div class="min-h-screen">

    {{-- SIDEBAR SESUAI ROLE AKTIF --}}
    @php
        $activeRole = session('active_role', 'guru');
    @endphp

    @if(auth()->check() && $activeRole === 'admin')
        @include('layouts.sidebar.admin')

    @elseif(auth()->check() && $activeRole === 'piket')
        @include('layouts.sidebar.guru-piket')

    @elseif(auth()->check() && $activeRole === 'guru')
        @include('layouts.sidebar.guru-mapel')
    @endif


    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

</div>

@include('components.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>

</body>
</html>