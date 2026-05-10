<?php

namespace App\Policies;

use App\Models\Jurnal;
use App\Models\User;

class JurnalPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // filtering tetap di controller
    }

    public function view(User $user, Jurnal $jurnal): bool
    {
        return $user->role === 'admin'
            || $user->id === $jurnal->user_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'guru', 'piket']);
    }

    public function update(User $user, Jurnal $jurnal): bool
    {
        return $user->role === 'admin'
            || $user->id === $jurnal->user_id;
    }

    public function delete(User $user, Jurnal $jurnal): bool
    {
        return $user->role === 'admin'
            || $user->id === $jurnal->user_id;
    }
}