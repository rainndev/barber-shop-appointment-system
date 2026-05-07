<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user is admin.
     */
    public function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }
}
