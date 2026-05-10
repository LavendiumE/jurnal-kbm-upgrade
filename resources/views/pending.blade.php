<x-guest-layout>
    <div class="max-w-md mx-auto text-center">

        <div class="bg-yellow-100 p-6 rounded-lg shadow-sm">
            <h1 class="text-xl font-semibold text-yellow-800 mb-2">
                Akun Menunggu Approval
            </h1>

            <p class="text-sm text-yellow-700">
                Akun kamu sudah terdaftar, tapi belum disetujui oleh admin.
                Silakan hubungi admin atau tunggu konfirmasi.
            </p>

            <div class="mt-6">
                <a href="{{ route('login') }}"
                   class="text-indigo-600 hover:underline text-sm">
                    Kembali ke Login
                </a>
            </div>
        </div>

    </div>
</x-guest-layout>