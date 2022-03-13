<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SquidUser\CreateRequest;
use App\Http\Requests\SquidUser\DestroyRequest;
use App\Http\Requests\SquidUser\ModifyRequest;
use App\Http\Requests\SquidUser\SearchRequest;
use App\Http\Resources\SquidUserCollection;
use App\Http\Resources\SquidUserResource;
use App\UseCases\SquidUser\CreateAction;
use App\UseCases\SquidUser\DestroyAction;
use App\UseCases\SquidUser\ModifyAction;
use App\UseCases\SquidUser\SearchAction;

class SquidUserController extends Controller
{
    public function search(SearchRequest $request, SearchAction $action) : SquidUserCollection{
        $user=  $request->searchSquidUser();
        $query = $request->validated();

        return new SquidUserCollection($action($user,$query));
    }

    public function create(CreateRequest $request, CreateAction $action) : SquidUserResource{
        $user = $request->createSquidUser();

        return new SquidUserResource($action($user));
    }

    public function modify(ModifyRequest $request, ModifyAction $action) : SquidUserResource{
        $user = $request->modifySquidUser();

        return new SquidUserResource($action($user));
    }

    public function destroy(DestroyRequest $request, DestroyAction $action) : SquidUserResource{
        $user = $request->destroySquidUser();

        return new SquidUserResource($action($user));
    }
}
