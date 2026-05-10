<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Guru;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_approved' => 0,
        ]);

        // attach default role guru
        $guruRole = Role::where('name', 'guru')->first();
        $user->roles()->attach($guruRole->id);

        // otomatis buat data guru
        Guru::create([
            'user_id' => $user->id,
            'nama' => $user->name,
        ]);

        event(new Registered($user));

        return redirect()->route('login')
            ->with('status', 'Registrasi berhasil. Tunggu approval admin.');
    }
}