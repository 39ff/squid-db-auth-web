<?php
namespace App\UseCases\User;

use App\Models\User;
use function assert;

class CreateAction{
    public function __invoke(User $user): User
    {
        assert(! $user->exists);
        $user->save();
        return $user;
    }
}
