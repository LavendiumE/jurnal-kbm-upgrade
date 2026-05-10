<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{

    public function dashboard()
    {

        $jurnals = Jurnal::latest()->take(10)->get();

        return view('guru.dashboard', compact('jurnals'));

    }

    public function index()
    {
        $data = User::with(['guru', 'roles'])
            ->whereHas('guru')
            ->get();

        return view('admin.gurus.index', compact('data'));
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make('12345678')
        ]);

        return back()->with('success', 'Password berhasil direset');
    }

    public function togglePiket($id)
    {
        $user = User::findOrFail($id);

        $piketRole = Role::where('name', 'piket')->first();

        if (!$piketRole) {
            return back()->with('error', 'Role piket belum tersedia');
        }

        if ($user->hasRole('piket')) {
            $user->roles()->detach($piketRole->id);
        } else {
            $user->roles()->syncWithoutDetaching([$piketRole->id]);
        }

        return back()->with('success', 'Akses guru piket berhasil diupdate');
    }
}