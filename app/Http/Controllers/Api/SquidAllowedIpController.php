<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SquidAllowedIp\CreateRequest;
use App\Http\Requests\SquidAllowedIp\DestroyRequest;
use App\Http\Requests\SquidAllowedIp\SearchRequest;
use App\Http\Resources\SquidAllowedIpCollection;
use App\Http\Resources\SquidAllowedIpResource;
use App\UseCases\AllowedIp\CreateAction;
use App\UseCases\AllowedIp\DestroyAction;
use App\UseCases\AllowedIp\SearchAction;

class SquidAllowedIpController extends Controller
{
    public function search(SearchRequest $request, SearchAction $action) : SquidAllowedIpCollection
    {
        $query = $request->searchSquidAllowedIp();

        return new SquidAllowedIpCollection($action($query));
    }

    public function create(CreateRequest $request, CreateAction $action) : SquidAllowedIpResource
    {
        $squidAllowedIp = $request->createSquidAllowedIp();

        return new SquidAllowedIpResource($action($squidAllowedIp));
    }

    public function destroy(DestroyRequest $request, DestroyAction $action): SquidAllowedIpResource
    {
        $squidAllowedIp = $request->destroySquidAllowedIp();

        return new SquidAllowedIpResource($action($squidAllowedIp));
    }
}
