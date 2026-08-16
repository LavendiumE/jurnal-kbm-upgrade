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

                @php
                    $setting = \App\Models\Setting::first();
                @endphp

                <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3">

                    @if($setting && $setting->logo)

                        <img
                            src="{{ asset('storage/'.$setting->logo) }}"
                            class="w-10 h-10 object-contain">

                    @endif

                    <span class="text-lg font-semibold">

                        {{ $setting->nama_sekolah ?? 'JURNAL-KBM' }}

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
                {{ request()->routeIs('admin.dashboard')
                ? 'bg-gray-100 text-blue-600'
                : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75V19.5a.75.75 0 00.75.75H9.75v-6h4.5v6h4.5a.75.75 0 00.75-.75V9.75" />
                    </svg>

                    <span>Dashboard</span>

                </a>
            </li>

            {{-- APPROVAL --}}
            <li>
                <a href="{{ route('admin.pending') }}"
                   class="flex items-center px-3 py-2 rounded-lg
                   {{ request()->routeIs('admin.pending') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                    </svg>

                    <span>Approval</span>
                </a>
            </li>

            {{-- JADWAL --}}
            <li>
                <a href="{{ route('admin.jadwals.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg
                   {{ request()->routeIs('admin.jadwals.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                    </svg>
                    <span>Jadwal KBM</span>
                </a>
            </li>

            {{-- JURNAL KBM --}}
            <li>
                <a href="{{ route('admin.jurnals.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.jurnals.*')
                ? 'bg-gray-100 text-blue-600'
                : 'hover:bg-gray-100 text-gray-700' }}">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>


                <span>Jurnal KBM</span>

                </a>
            </li>

            {{-- JURNAL GURU PIKET --}}
            <li>
                <a href="{{ route('admin.jurnal-piket.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.jurnal-piket.*')
                ? 'bg-gray-100 text-blue-600'
                : 'hover:bg-gray-100 text-gray-700' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 mr-3">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />

                </svg>

                <span>Jurnal Guru Piket</span>

                </a>
            </li>

            {{-- MASTER DATA --}}
            <li class="pt-4">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Master Data
                </p>
            </li>

            {{-- DATA JURUSAN --}}
            <li>
                <a href="{{ route('admin.jurusans.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.jurusans.*')
                        ? 'bg-gray-100 text-blue-600'
                        : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 4.5h16.5v15H3.75V4.5Z" />
                    </svg>

                    <span>Data Jurusan</span>
                </a>
            </li>

            {{-- DATA KELAS --}}
            <li>
                <a href="{{ route('admin.kelas.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.kelas.*')
                        ? 'bg-gray-100 text-blue-600'
                        : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4.5 6.75h15m-15 5.25h15m-15 5.25h15" />
                    </svg>

                    <span>Data Kelas</span>
                </a>
            </li>

            {{-- DATA MAPEL --}}
            <li>
                <a href="{{ route('admin.mapels.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.mapels.*')
                        ? 'bg-gray-100 text-blue-600'
                        : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 3.75 4.5v13.5A8.967 8.967 0 0 1 12 19.5a8.967 8.967 0 0 1 8.25-1.5V4.5A8.967 8.967 0 0 0 12 6.042Z" />
                    </svg>

                    <span>Data Mapel</span>
                </a>
            </li>

            {{-- DATA RUANGAN --}}
            <li>
                <a href="{{ route('admin.ruangans.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.ruangans.*')
                        ? 'bg-gray-100 text-blue-600'
                        : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15v18h-15V3Z" />
                    </svg>

                    <span>Data Ruangan</span>
                </a>
            </li>

            {{-- DATA GURU --}}
            <li>
                <a href="{{ route('admin.gurus.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.gurus.*')
                        ? 'bg-gray-100 text-blue-600'
                        : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z" />
                    </svg>

                    <span>Data Guru</span>
                </a>
            </li>

            {{-- DATA SISWA --}}
            <li>
                <a href="{{ route('admin.siswa.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.siswa.*')
                        ? 'bg-gray-100 text-blue-600'
                        : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.37 9.37 0 0 0 2.25-.273V7.5a9 9 0 0 0-9-9 9 9 0 0 0-9 9v11.727a9.37 9.37 0 0 0 2.25.273c.926 0 1.813-.135 2.625-.372M15 19.128v-3.75a3.75 3.75 0 0 0-7.5 0v3.75M15 19.128c-1.147.416-2.373.642-3.75.642s-2.603-.226-3.75-.642M12 7.5a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />

                    </svg>

                    <span>Data Siswa</span>

                </a>
            </li>

            {{-- PENGATURAN TITLE --}}
            <li class="pt-4">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Pengaturan
                </p>
            </li>

            {{-- PENGATURAN --}}
            <li>
                <a href="{{ route('admin.settings.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.settings.*')
                        ? 'bg-gray-100 text-blue-600'
                        : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>


                    <span>Pengaturan Sekolah</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.jurnal-settings.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.jurnal-settings.*')
                        ? 'bg-gray-100 text-blue-600'
                        : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />

                    </svg>

                    <span>Pengaturan Jurnal</span>

                </a>
            </li>
            {{-- JAM KBM --}}
            <li>
                <a href="{{ route('admin.jam-kbm.index') }}"
                class="flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.jam-kbm.*')
                        ? 'bg-gray-100 text-blue-600'
                        : 'hover:bg-gray-100 text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mr-3">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />

                    </svg>

                    <span>Jam KBM</span>

                </a>
            </li>
        </ul>
    </div>
</aside>