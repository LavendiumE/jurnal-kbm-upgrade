<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        /**
         * Cek approval admin
         */
        if (!$user->is_approved) {
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'Akun kamu masih menunggu approval admin.');
        }

        /**
         * ADMIN
         */
        if ($user->hasRole('admin')) {
            session(['active_role' => 'admin']);

            return redirect()->route('admin.dashboard');
        }

        /**
         * DEFAULT GURU MAPEL
         */
        session(['active_role' => 'guru']);

        return redirect()->route('guru.jurnals.index');
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}