<div class="bg-white border-bottom shadow-sm px-4 py-2 d-flex justify-content-between align-items-center">

    <!-- LEFT -->
    <div class="d-flex align-items-center gap-3">

        <h5 class="mb-0 fw-semibold">
            Sistem Jurnal Sekolah
        </h5>

    </div>

    <!-- RIGHT -->
    <div class="d-flex align-items-center gap-3">

        <span class="text-muted small">
            {{ auth()->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="btn btn-sm btn-outline-danger">
                Logout
            </button>

        </form>

    </div>

</div>