<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        // Cek kalau sudah login
        if (auth()->check()) {

            // Kalau belum di-approve
            if (!auth()->user()->is_approved) {

                auth()->logout();

                return redirect()
                    ->route('login')
                    ->with('error', 'Akun Anda belum disetujui admin.');
            }
        }

        return $next($request);
    }
}