<x-guest-layout>
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

        <h1 class="text-2xl font-semibold text-gray-800 mb-1">
            Login
        </h1>
        <p class="text-sm text-gray-500 mb-6">
            Masuk untuk melanjutkan ke aplikasi
        </p>

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
                    <input type="checkbox" onclick="togglePassword('password')" class="mr-2">
                    Tampilkan password
                </label>
            </div>

            <!-- Remember -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2">
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

                <x-primary-button>
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