<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Jurnal;
use App\Policies\JurnalPolicy;
use App\Models\SiswaIzinKeluar;
use App\Models\SiswaPulangAwal;
use App\Policies\SiswaIzinKeluarPolicy;
use App\Policies\SiswaPulangAwalPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Jurnal::class, JurnalPolicy::class);
        
        Gate::policy(SiswaIzinKeluar::class, SiswaIzinKeluarPolicy::class);
        Gate::policy(SiswaPulangAwal::class, SiswaPulangAwalPolicy::class);
    }

}


