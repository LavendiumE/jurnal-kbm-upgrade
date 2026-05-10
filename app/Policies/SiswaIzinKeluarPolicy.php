<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SiswaIzinKeluar;

class SiswaIzinKeluarPolicy
{
    // Admin & piket boleh lihat semua
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'piket']);
    }

    // Admin boleh lihat semua, piket hanya miliknya
    public function view(User $user, SiswaIzinKeluar $izin): bool
    {
        return $user->role === 'admin'
            || $izin->user_id === $user->id;
    }

    // Hanya guru piket yang boleh create
    public function create(User $user): bool
    {
        return $user->role === 'piket';
    }

    // Hanya guru piket pemilik data
    public function delete(User $user, SiswaIzinKeluar $izin): bool
    {
        return $user->role === 'piket'
            && $izin->user_id === $user->id;
    }
}