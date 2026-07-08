<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AccessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JurnalController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\JadwalController;

use App\Http\Controllers\SiswaIzinKeluarController;
use App\Http\Controllers\SiswaPulangAwalController;
use App\Http\Controllers\SiswaTerlambatController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\JurnalPiketController;
use App\Http\Controllers\PiketDashboardController;


use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\GuruController;

use App\Http\Controllers\InformasiController;
use App\Http\Controllers\Admin\AdminJurnalController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\JurnalSettingController;


/*
|--------------------------------------------------------------------------
| ACCESS GATE
|--------------------------------------------------------------------------
*/

Route::get('/', [AccessController::class, 'index'])->name('access.index');

Route::get('/access', [AccessController::class, 'index']);

Route::post('/access', [AccessController::class, 'check'])
    ->name('access.check');


/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/

Route::middleware(['guest', 'access'])->group(function () {

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD REDIRECT BERDASARKAN ROLE AKTIF
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        if (!auth()->user()->is_approved) {
            return redirect()->route('login')
                ->with('error', 'Akun kamu masih menunggu approval admin');
        }

        if (session('active_role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (session('active_role') === 'piket') {
            return redirect()->route('piket.dashboard');
        }

        return redirect()->route('guru.jurnals.index');

    })->name('dashboard');

    Route::view(
        '/change-password',
        'auth.change-password'
    )->name('password.edit');


    /*
    |--------------------------------------------------------------------------
    | GURU MAPEL
    |--------------------------------------------------------------------------
    */

    Route::prefix('guru')->group(function () {

        Route::get('/dashboard', function () {
            return redirect()->route('guru.jurnals.index');
        })->name('guru.dashboard');

        Route::resource('jurnals', JurnalController::class)
            ->names('guru.jurnals');

        Route::get('/jurnals/export/mine', [JurnalController::class, 'exportMine'])
            ->name('guru.jurnals.export.mine');

        Route::get('/jurnals/export/all', [JurnalController::class, 'exportAll'])
            ->name('guru.jurnals.export.all');

    });

    /*
    |--------------------------------------------------------------------------
    | GURU PIKET
    |--------------------------------------------------------------------------
    */

    Route::prefix('piket')->group(function () {

        Route::get('/dashboard', [PiketDashboardController::class, 'index'])
        ->name('piket.dashboard');

        /*
        | PERIZINAN
        */

        Route::prefix('perizinan')->group(function () {

            Route::get('/', function () {
                return view('piket.perizinan.index');
            })->name('piket.perizinan.index');

            Route::get('/izin-keluar', [SiswaIzinKeluarController::class, 'index'])
                ->name('piket.perizinan.keluar.index');

            Route::get('/izin-keluar/create', [SiswaIzinKeluarController::class, 'create'])
                ->name('piket.perizinan.keluar.create');

            Route::post('/izin-keluar/store', [SiswaIzinKeluarController::class, 'store'])
                ->name('piket.perizinan.keluar.store');

            Route::get('/izin-keluar/{id}/edit', [SiswaIzinKeluarController::class, 'edit'])
                ->name('piket.perizinan.keluar.edit');

            Route::delete('/izin-keluar/{id}', [SiswaIzinKeluarController::class, 'destroy'])
                ->name('piket.perizinan.keluar.destroy');

            Route::put('/izin-keluar/{id}', [SiswaIzinKeluarController::class, 'update'])
                ->name('piket.perizinan.keluar.update');
                
            Route::get('/izin-keluar/export', [SiswaIzinKeluarController::class, 'export'])
                ->name('piket.perizinan.keluar.export');


            Route::get('/pulang-awal', [SiswaPulangAwalController::class, 'index'])
                ->name('piket.perizinan.pulang.index');

            Route::get('/pulang-awal/create', [SiswaPulangAwalController::class, 'create'])
                ->name('piket.perizinan.pulang.create');

            Route::post('/pulang-awal/store', [SiswaPulangAwalController::class, 'store'])
                ->name('piket.perizinan.pulang.store');

            Route::get('/pulang-awal/{id}/edit', [SiswaPulangAwalController::class, 'edit'])
                ->name('piket.perizinan.pulang.edit');

            Route::delete('/pulang-awal/{id}', [SiswaPulangAwalController::class, 'destroy'])
                ->name('piket.perizinan.pulang.destroy');

            Route::put('/pulang-awal/{id}', [SiswaPulangAwalController::class, 'update'])
                ->name('piket.perizinan.pulang.update');

            Route::get('/izin-pulang-awal/export', [SiswaPulangAwalController::class, 'export'])
                ->name('piket.perizinan.pulang.export');

            Route::get('/terlambat', [SiswaTerlambatController::class, 'index'])
                ->name('piket.perizinan.terlambat.index');

            Route::get('/terlambat/create', [SiswaTerlambatController::class, 'create'])
                ->name('piket.perizinan.terlambat.create');

            Route::post('/terlambat/store', [SiswaTerlambatController::class, 'store'])
                ->name('piket.perizinan.terlambat.store');

            Route::get('/terlambat/{id}/edit', [SiswaTerlambatController::class, 'edit'])
                ->name('piket.perizinan.terlambat.edit');

            Route::delete('/terlambat/{id}', [SiswaTerlambatController::class, 'destroy'])
                ->name('piket.perizinan.terlambat.destroy');

            Route::put('/terlambat/{id}', [SiswaTerlambatController::class, 'update'])
                ->name('piket.perizinan.terlambat.update');

            Route::get('/siswa-terlambat/export', [SiswaTerlambatController::class, 'export'])
                ->name('piket.siswa.terlambat.export');
        });


        /*
        | JURNAL GURU PIKET
        */

        Route::get('/jurnal', [JurnalPiketController::class, 'index'])
            ->name('piket.jurnal.index');

        Route::get('/jurnal/create', [JurnalPiketController::class, 'create'])
            ->name('piket.jurnal.create');

        Route::post('/jurnal/store', [JurnalPiketController::class, 'store'])
            ->name('piket.jurnal.store');

        Route::get('/jurnal/{id}/edit', [JurnalPiketController::class, 'edit'])
            ->name('piket.jurnal.edit');
        
        Route::delete('/jurnal/{id}', [JurnalPiketController::class, 'destroy'])
            ->name('piket.jurnal.destroy');

        Route::put('/jurnal/{id}', [JurnalPiketController::class, 'update'])
            ->name('piket.jurnal.update');
        
        Route::get('/jurnal/export', [JurnalPiketController::class, 'export'])
            ->name('piket.jurnal.export');

    });


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::get('/pending-users', [AdminController::class, 'pendingUsers'])
            ->name('admin.pending');

        Route::get('/approve/{id}', [AdminController::class, 'approve'])
            ->name('admin.approve');

        Route::get('/jadwals/export', [JadwalController::class, 'export'])
            ->name('admin.jadwals.export');

        Route::resource('jadwals', JadwalController::class)
            ->names('admin.jadwals');

        Route::get('/master-data', function () {
            return view('admin.master-data');
        })->name('admin.master-data');

        Route::get('/kelas', [KelasController::class, 'index'])->name('admin.kelas.index');
        Route::post('/kelas', [KelasController::class, 'store'])->name('admin.kelas.store');
        Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');

        Route::get('/mapels', [MapelController::class, 'index'])->name('admin.mapels.index');
        Route::post('/mapels', [MapelController::class, 'store'])->name('admin.mapels.store');
        Route::delete('/mapels/{id}', [MapelController::class, 'destroy'])->name('admin.mapels.destroy');

        Route::get('/ruangans', [RuanganController::class, 'index'])->name('admin.ruangans.index');
        Route::post('/ruangans', [RuanganController::class, 'store'])->name('admin.ruangans.store');
        Route::delete('/ruangans/{id}', [RuanganController::class, 'destroy'])->name('admin.ruangans.destroy');

        Route::get('/jurusans', [JurusanController::class, 'index'])->name('admin.jurusans.index');
        Route::post('/jurusans', [JurusanController::class, 'store'])->name('admin.jurusans.store');
        Route::delete('/jurusans/{id}', [JurusanController::class, 'destroy'])->name('admin.jurusans.destroy');

        Route::get('/gurus', [GuruController::class, 'index'])->name('admin.gurus.index');

        Route::post('/gurus/{id}/reset-password', [GuruController::class, 'resetPassword'])
            ->name('admin.gurus.reset-password');

        Route::post('/gurus/{id}/toggle-piket', [GuruController::class, 'togglePiket'])
            ->name('admin.gurus.toggle-piket');

        Route::post('/informasi', [InformasiController::class, 'store'])->name('admin.informasi.store');
        Route::delete('/informasi/{id}', [InformasiController::class, 'destroy'])->name('admin.informasi.destroy');

         // JURNAL KBM ADMIN
        Route::get(
            '/jurnals',
            [AdminJurnalController::class, 'index']
        )->name('admin.jurnals.index');

        Route::get(
            '/jurnals/export',
            [AdminJurnalController::class, 'export']
        )->name('admin.jurnals.export');

        Route::get('/settings', [SettingController::class, 'index'])
            ->name('admin.settings.index');

        Route::post('/settings', [SettingController::class, 'update'])
            ->name('admin.settings.update');
        Route::get('/jurnal-settings', [JurnalSettingController::class, 'index'])
            ->name('admin.jurnal-settings.index');

        Route::post('/jurnal-settings', [JurnalSettingController::class, 'update'])
            ->name('admin.jurnal-settings.update');
    });


        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


        /*
        |--------------------------------------------------------------------------
        | SWITCH ROLE
        |--------------------------------------------------------------------------
        */

    Route::post('/switch-role', function (Request $request) {

            
        if (in_array($request->role, ['guru', 'piket', 'admin'])) {
            session(['active_role' => $request->role]);
        }

        return redirect()->route('dashboard');
            

    })->name('switch.role');

    Route::post(
    '/admin/gurus/{id}/toggle-active',
    [GuruController::class,'toggleActive']
    )->name('admin.gurus.toggle-active');

});

require __DIR__ . '/auth.php';