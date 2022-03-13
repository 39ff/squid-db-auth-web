<?php
namespace App\UseCases\User;

use App\Models\User;
use function assert;

class DestroyAction{
    /**
     * @param User $user
     * @return User
     */
    public function __invoke(User $user): User
    {
        assert($user->id !== null);
        $destroyUser = User::query()->where('id','=',$user->id)->first();
        assert($destroyUser->exists);
        assert($destroyUser->is_administrator === 0);
        $destroyUser->delete();
        return $destroyUser;
    }
}
