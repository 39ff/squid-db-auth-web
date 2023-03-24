<?php

namespace App\Policies;

use App\Models\SquidAllowedIp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AllowedIpPolicy
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

    public function create(User $user, string $toSpecifiedUserId)
    {
        if ($user->is_administrator === 1) {
            return true;
        }

        if (strcmp((string) $user->id, $toSpecifiedUserId) === 0) {
            return true;
        }

        return false;
    }

    public function destroy(User $user, SquidAllowedIp $squidAllowedIp)
    {
        if ($user->is_administrator === 1) {
            return true;
        }

        if (strcmp((string) $user->id, (string) $squidAllowedIp->user_id) === 0) {
            return true;
        }

        return false;
    }
}
