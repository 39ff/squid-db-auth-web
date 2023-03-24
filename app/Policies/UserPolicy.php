<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->is_administrator === 1;
    }

    public function modify(User $user, string $updateUserId)
    {
        if ($user->is_administrator === 1) {
            return true;
        }

        if (strcmp((string) $user->id, $updateUserId) === 0) {
            return true;
        }

        return false;
    }

    public function destroy(User $user)
    {
        return $user->is_administrator === 1;
    }

    public function search(User $user)
    {
        return $user->is_administrator === 1;
    }
}
