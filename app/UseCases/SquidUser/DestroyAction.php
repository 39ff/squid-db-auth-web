<?php
namespace App\UseCases\SquidUser;

use App\Models\SquidUser;
use function assert;

class DestroyAction{
    public function __invoke(SquidUser $squidUser): SquidUser
    {
        $modifyUser = SquidUser::query()->where('id','=',$squidUser->id)->first();
        assert($modifyUser->exists);
        $modifyUser->delete();
        return $modifyUser;
    }
}
