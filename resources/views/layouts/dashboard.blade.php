<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jurnal KBM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-md">

        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-gray-800">
                JURNAL KBM
            </h1>
        </div>

        <nav class="mt-4 flex flex-col">

            <a href="{{ route('dashboard') }}"
               class="px-6 py-3 hover:bg-gray-100">
               Dashboard
            </a>

            <a href="{{ route('jurnals.index') }}"
               class="px-6 py-3 hover:bg-gray-100">
               Jurnal KBM
            </a>

            <a href="#"
               class="px-6 py-3 hover:bg-gray-100">
               Perizinan
            </a>

            <a href="{{ route('guru.piket.dashboard') }}"
               class="px-6 py-3 hover:bg-gray-100">
               Guru Piket
            </a>

        </nav>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">

            <h2 class="text-lg font-semibold">
                @yield('title')
            </h2>

            <div class="flex items-center gap-4">

                <span class="text-gray-600">
                    {{ Auth::user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-500">
                        Logout
                    </button>
                </form>

            </div>

        </header>


        <!-- CONTENT -->
        <div class="p-8">

            @yield('content')

        </div>

    </main>

</div>

</body>
</html>