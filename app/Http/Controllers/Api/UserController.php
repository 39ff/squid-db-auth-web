<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SearchRequest;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\DestroyRequest;
use App\Http\Requests\User\ModifyRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\UseCases\User\SearchAction;
use App\UseCases\User\CreateAction;
use App\UseCases\User\DestroyAction;
use App\UseCases\User\ModifyAction;

class UserController extends Controller
{
    public function search(SearchRequest $request, SearchAction $action) : UserCollection{
        $user = $request->searchUser();
        $query = $request->validated();

        return new UserCollection($action($user,$query));
    }

    public function create(CreateRequest $request, CreateAction $action) : UserResource{
        $user = $request->createUser();

        return new UserResource($action($user));
    }

    public function modify(ModifyRequest $request, ModifyAction $action) : UserResource{
        $user = $request->modifyUser();

        return new UserResource($action($user));
    }

    public function destroy(DestroyRequest $request, DestroyAction $action) : UserResource{
        $user = $request->destroyUser();

        return new UserResource($action($user));
    }
}
