<?php

namespace App\Policies;

use App\Models\SquidUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SquidUserPolicy
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

    public function search(User $user, string $toSpecifiedUserId)
    {
        if ($user->is_administrator === 1) {
            return true;
        }

        if (strcmp((string) $user->id, $toSpecifiedUserId) === 0) {
            return true;
        }

        return false;
    }

    public function create(User $user, string $toSpecifiedUserId): bool
    {
        if ($user->is_administrator === 1) {
            return true;
        }

        if (strcmp((string) $user->id, $toSpecifiedUserId) === 0) {
            return true;
        }

        return false;
    }

    public function modify(User $user, SquidUser $squidUser)
    {
        if ($user->is_administrator === 1) {
            return true;
        }

        if (strcmp((string) $user->id, (string) $squidUser->user_id) === 0) {
            return true;
        }

        return false;
    }

    public function destroy(User $user, SquidUser $squidUser)
    {
        if ($user->is_administrator === 1) {
            return true;
        }

        if (strcmp((string) $user->id, (string) $squidUser->user_id) === 0) {
            return true;
        }

        return false;
    }
}
