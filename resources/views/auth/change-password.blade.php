@extends('layouts.app')

@section('content')

<div class="p-4 sm:ml-64 mt-16">

    <div class="max-w-2xl mx-auto">

        {{-- ALERT SUCCESS --}}
        @if(session('status') === 'password-updated')

        <div id="success-alert"
             class="mb-4 flex items-center gap-3 p-4 rounded-lg
                    bg-green-50 border border-green-200 text-green-700">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"/>

            </svg>

            <span>
                Password berhasil diperbarui
            </span>

        </div>

        @endif


        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-xl font-semibold mb-6">

                Ubah Password

            </h2>

            <form method="POST"
                  action="{{ route('password.update') }}">

                @csrf
                @method('PUT')


                {{-- PASSWORD LAMA --}}
                <div>

                    <label class="block text-sm font-medium mb-2">

                        Password Lama

                    </label>

                    <div class="relative">

                        <input
                            id="current_password"
                            type="password"
                            name="current_password"
                            class="w-full border rounded-lg px-4 py-2 pr-12"
                            required
                        >

                        <button
                            type="button"
                            onclick="togglePassword('current_password')"
                            class="absolute right-3 top-2 text-gray-500">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0
                                         3 3 0 016 0z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M2.458 12C3.732 7.943
                                         7.523 5 12 5
                                         c4.478 0 8.268 2.943
                                         9.542 7
                                         -1.274 4.057
                                         -5.064 7
                                         -9.542 7
                                         -4.477 0
                                         -8.268-2.943
                                         -9.542-7z"/>

                            </svg>

                        </button>

                    </div>

                    @error('current_password', 'updatePassword')

                    <p class="text-red-500 text-sm mt-2">

                        {{ $message }}

                    </p>

                    @enderror

                </div>



                {{-- PASSWORD BARU --}}
                <div class="mt-4">

                    <label class="block text-sm font-medium mb-2">

                        Password Baru

                    </label>

                    <div class="relative">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="w-full border rounded-lg px-4 py-2 pr-12"
                            required
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password')"
                            class="absolute right-3 top-2 text-gray-500">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0
                                         3 3 0 016 0z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M2.458 12C3.732 7.943
                                         7.523 5 12 5
                                         c4.478 0 8.268 2.943
                                         9.542 7
                                         -1.274 4.057
                                         -5.064 7
                                         -9.542 7
                                         -4.477 0
                                         -8.268-2.943
                                         -9.542-7z"/>

                            </svg>

                        </button>

                    </div>

                    @error('password', 'updatePassword')

                    <p class="text-red-500 text-sm mt-2">

                        {{ $message }}

                    </p>

                    @enderror

                </div>



                {{-- KONFIRMASI PASSWORD --}}
                <div class="mt-4">

                    <label class="block text-sm font-medium mb-2">

                        Konfirmasi Password

                    </label>

                    <div class="relative">

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="w-full border rounded-lg px-4 py-2 pr-12"
                            required
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password_confirmation')"
                            class="absolute right-3 top-2 text-gray-500">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0
                                         3 3 0 016 0z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M2.458 12C3.732 7.943
                                         7.523 5 12 5
                                         c4.478 0 8.268 2.943
                                         9.542 7
                                         -1.274 4.057
                                         -5.064 7
                                         -9.542 7
                                         -4.477 0
                                         -8.268-2.943
                                         -9.542-7z"/>

                            </svg>

                        </button>

                    </div>

                </div>



                <div class="mt-6">

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700
                               text-white px-5 py-2 rounded-lg">

                        Simpan Password

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

function togglePassword(id)
{
    const input =
        document.getElementById(id);

    input.type =
        input.type === 'password'
        ? 'text'
        : 'password';
}


setTimeout(() => {

    let alert =
        document.getElementById(
            'success-alert'
        );

    if(alert)
    {
        alert.remove();
    }

}, 3000);

</script>

@endsection