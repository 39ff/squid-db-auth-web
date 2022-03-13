<?php
namespace App\UseCases\SquidUser;

use App\Models\SquidUser;
use function assert;

class CreateAction{
    public function __invoke(SquidUser $user): SquidUser
    {
        assert(! $user->exists);
        $user->save();
        return $user;
    }
}
