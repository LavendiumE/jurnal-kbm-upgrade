<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessGate
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('access_granted')) {
            return redirect()->route('access.index');
        }

        return $next($request);
    }
}
