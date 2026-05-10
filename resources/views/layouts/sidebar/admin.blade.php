{{-- TOP NAV --}}
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">

            {{-- LEFT --}}
            <div class="flex items-center">
                <button
                    data-drawer-target="top-bar-sidebar"
                    data-drawer-toggle="top-bar-sidebar"
                    class="sm:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg">

                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M5 7h14M5 12h14M5 17h10"/>
                    </svg>
                </button>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center ms-2">
                    <span class="text-lg font-semibold text-gray-800">
                        JURNAL-KBM
                    </span>
                </a>
            </div>

            {{-- USER --}}
            <div>
                <button
                    type="button"
                    class="flex items-center text-sm rounded-full focus:ring-2"
                    data-dropdown-toggle="dropdown-user">

                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-xs">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </button>

                {{-- DROPDOWN --}}
                <div id="dropdown-user"
                     class="hidden z-50 mt-2 w-44 bg-white rounded-lg shadow border">

                    <div class="px-4 py-3 border-b">
                        <p class="text-sm font-medium">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <div class="p-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button class="w-full text-left p-2 text-sm hover:bg-gray-100 rounded text-red-500">
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</nav>



{{-- SIDEBAR --}}
<aside id="top-bar-sidebar"
       class="fixed top-0 left-0 z-40 w-64 h-full pt-16 transition-transform -translate-x-full sm:translate-x-0">

    <div class="h-full px-3 py-4 overflow-y-auto bg-white border-r">

        {{-- TITLE --}}
        <div class="mb-6 px-2">
            <p class="text-xs text-gray-400 uppercase">
                Admin Panel
            </p>
        </div>

        {{-- MENU --}}
        <ul class="space-y-2 text-sm">

            {{-- DASHBOARD --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-3 py-2 rounded-lg
                   {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">

                    <span>Dashboard</span>
                </a>
            </li>

            {{-- APPROVAL --}}
            <li>
                <a href="{{ route('admin.pending') }}"
                   class="flex items-center px-3 py-2 rounded-lg
                   {{ request()->routeIs('admin.pending') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">

                    <span>Approval</span>
                </a>
            </li>

            {{-- JADWAL --}}
            <li>
                <a href="{{ route('admin.jadwals.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg
                   {{ request()->routeIs('admin.jadwals.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">

                    <span>Jadwal KBM</span>
                </a>
            </li>

            {{-- MASTER DATA --}}
            <li x-data="{ open: {{ request()->routeIs('admin.jurusans.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapels.*') || request()->routeIs('admin.ruangans.*') || request()->routeIs('admin.gurus.*') ? 'true' : 'false' }} }">

                <button @click="open = !open"
                        class="w-full flex justify-between items-center px-3 py-2 rounded-lg
                        hover:bg-gray-100 text-gray-700">

                    <span>Master Data</span>

                    <svg class="w-4 h-4 transition-transform"
                        :class="{ 'rotate-180': open }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>

                </button>

                <ul x-show="open" x-cloak
                x-transition
                class="ml-4 mt-2 space-y-1">

                    <li>
                        <a href="{{ route('admin.jurusans.index') }}"
                        class="block px-3 py-2 rounded
                        {{ request()->routeIs('admin.jurusans.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">
                            Data Jurusan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.kelas.index') }}"
                        class="block px-3 py-2 rounded
                        {{ request()->routeIs('admin.kelas.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">
                            Data Kelas
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.mapels.index') }}"
                        class="block px-3 py-2 rounded
                        {{ request()->routeIs('admin.mapels.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">
                            Data Mapel
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.ruangans.index') }}"
                        class="block px-3 py-2 rounded
                        {{ request()->routeIs('admin.ruangans.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">
                            Data Ruangan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.gurus.index') }}"
                        class="block px-3 py-2 rounded
                        {{ request()->routeIs('admin.gurus.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">
                            Data Guru
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>