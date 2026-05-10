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
            Register
        </h1>
        <p class="text-sm text-gray-500 mb-6">
            Buat akun baru untuk mulai menggunakan aplikasi
        </p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" value="Nama Lengkap Beserta Gelar" />
                <x-text-input
                    id="name"
                    class="block mt-1 w-full"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

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

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" value="Confirm Password" />
                <x-text-input
                    id="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    required
                />

                <label class="flex items-center mt-2 text-sm text-gray-600">
                    <input type="checkbox" onclick="togglePassword('password_confirmation')" class="mr-2">
                    Tampilkan password
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-4">
                <a
                    href="{{ route('login') }}"
                    class="text-sm text-gray-600 hover:underline"
                >
                    Sudah punya akun?
                </a>

                <x-primary-button>
                    Register
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