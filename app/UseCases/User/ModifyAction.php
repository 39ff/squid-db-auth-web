<?php
namespace App\UseCases\User;

use App\Models\User;
use function assert;

class ModifyAction{
    /**
     * @param User $user
     * @return User
     */
    public function __invoke(User $user): User
    {
        assert($user->id !== null);
        $updateUser = User::query()->where('id','=',$user->id)->first();
        assert($updateUser->exists);
        $updateUser->fill($user->getAttributes());
        $updateUser->save();
        return $updateUser;
    }
}
