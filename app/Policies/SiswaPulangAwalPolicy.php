<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SiswaPulangAwal;

class SiswaPulangAwalPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'piket']);
    }

    public function view(User $user, SiswaPulangAwal $pulang): bool
    {
        return $user->role === 'admin'
            || $pulang->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'piket';
    }

    public function delete(User $user, SiswaPulangAwal $pulang): bool
    {
        return $user->role === 'piket'
            && $pulang->user_id === $user->id;
    }
}