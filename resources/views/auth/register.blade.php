<x-guest-layout>

    @php
        $setting = \App\Models\Setting::first();
    @endphp

    <div class="max-w-md mx-auto">

        {{-- STATUS SUCCESS --}}
        @if (session('status'))
            <div class="mb-4 p-3 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        {{-- ERROR GLOBAL --}}
        @if ($errors->any())
            <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- IDENTITAS SEKOLAH --}}
        <div class="text-center mb-8">

            {{-- LOGO --}}
            @if(!empty($setting?->logo))
                <div class="w-28 h-28 mx-auto mb-4 flex items-center justify-center">
                    <img
                        src="{{ asset('storage/' . $setting->logo) }}"
                        alt="Logo Sekolah"
                        class="max-w-full max-h-full object-contain">
                </div>
            @endif

            <h1
                class="text-gray-900 tracking-wide"
                style="font-size:40px; font-weight:bold;">
                {{ $setting->nama_sekolah ?? 'Sistem Jurnal KBM' }}
            </h1>

            {{-- TEKS LOGIN --}}
            <p class="text-gray-500 mt-2">
                {{ $setting->teks_login ?? 'Silakan login untuk melanjutkan' }}
            </p>

        </div>

        {{-- CARD --}}
        <form method="POST"
                  action="{{ route('register') }}"
                  class="space-y-5">

                @csrf

                {{-- Nama --}}
                <div>

                    <x-input-label
                        for="name"
                        value="Nama Lengkap Beserta Gelar" />

                    <x-text-input
                        id="name"
                        class="block mt-2 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus />

                    <x-input-error
                        :messages="$errors->get('name')"
                        class="mt-2" />

                </div>

                {{-- Email --}}
                <div>

                    <x-input-label
                        for="email"
                        value="Email" />

                    <x-text-input
                        id="email"
                        class="block mt-2 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required />

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2" />

                </div>

                {{-- Password --}}
                <div>

                    <x-input-label
                        for="password"
                        value="Password" />

                    <x-text-input
                        id="password"
                        class="block mt-2 w-full"
                        type="password"
                        name="password"
                        required />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2" />

                    <label class="flex items-center mt-3 text-sm text-gray-600">

                        <input
                            type="checkbox"
                            onclick="togglePassword('password')"
                            class="rounded border-gray-300 text-blue-600 shadow-sm mr-2">

                        Tampilkan password

                    </label>

                </div>

                {{-- Confirm Password --}}
                <div>

                    <x-input-label
                        for="password_confirmation"
                        value="Konfirmasi Password" />

                    <x-text-input
                        id="password_confirmation"
                        class="block mt-2 w-full"
                        type="password"
                        name="password_confirmation"
                        required />

                    <label class="flex items-center mt-3 text-sm text-gray-600">

                        <input
                            type="checkbox"
                            onclick="togglePassword('password_confirmation')"
                            class="rounded border-gray-300 text-blue-600 shadow-sm mr-2">

                        Tampilkan password

                    </label>

                </div>

                {{-- ACTION --}}
                <div class="flex items-center justify-between pt-4">

                    <a
                        href="{{ route('login') }}"
                        class="text-sm text-indigo-600 hover:underline">

                        Sudah punya akun?

                    </a>

                    <x-primary-button class="px-8 justify-center">

                        Register

                    </x-primary-button>

                </div>

            </form>
    </div>

    <script>
        function togglePassword(id) {

            const input = document.getElementById(id);

            input.type =
                input.type === 'password'
                ? 'text'
                : 'password';
        }
    </script>

</x-guest-layout>