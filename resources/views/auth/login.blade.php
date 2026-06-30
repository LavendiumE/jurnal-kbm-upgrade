<x-guest-layout>
    @php
        $setting = \App\Models\Setting::first();
    @endphp
    <div class="max-w-md mx-auto">

        {{-- STATUS SUCCESS --}}
        @if (session('status'))
            <div class="mb-4 p-3 text-sm text-green-700 bg-green-100 rounded">
                {{ session('status') }}
            </div>
        @endif

        {{-- ERROR GLOBAL --}}
        @if ($errors->any())
            <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 rounded">
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

        @if(session('error'))
        <div style="color:red; margin-bottom:10px;">
            {{ session('error') }}
        </div>
        @endif
       
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />

                    <label class="flex items-center mt-2 text-sm text-gray-600">
                        <input
                        type="checkbox"
                        onclick="togglePassword('password')"
                        class="rounded border-gray-300 text-blue-600 shadow-sm mr-2">
                        Tampilkan password
                    </label>
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-gray-600">
                        <input
                        type="checkbox"
                        onclick="togglePassword('password')"
                        class="rounded border-gray-300 text-blue-600 shadow-sm mr-2">
                        Remember me
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4">
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="text-sm text-indigo-600 hover:underline"
                        >
                            Belum punya akun? Register
                        </a>
                    @endif

                    <x-primary-button class="px-8 justify-center">
                        Login
                    </x-primary-button>
                </div>
            </form>
        
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>