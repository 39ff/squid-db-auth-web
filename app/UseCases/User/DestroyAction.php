<?php

namespace App\UseCases\User;

use App\Models\User;
use function assert;

class DestroyAction
{
    /**
     * @param User $destroyUser
     * @return User
     */
    public function __invoke(User $destroyUser): User
    {
        assert($destroyUser->exists);
        $countAdministrator = User::query()
            ->where('id', '<>', $destroyUser->id)
            ->where('is_administrator', '=', 1)
            ->count();
        //disable locked out.
        assert($countAdministrator !== 0);
        $destroyUser->delete();

        return $destroyUser;
    }
}
