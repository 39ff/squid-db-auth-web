<?php

namespace App\Http\Controllers\Gui;

use App\Http\Controllers\Controller;
use App\Http\Requests\SquidAllowedIp\CreateRequest;
use App\Http\Requests\SquidAllowedIp\DestroyRequest;
use App\Http\Requests\SquidAllowedIp\SearchRequest;
use App\UseCases\AllowedIp\CreateAction;
use App\UseCases\AllowedIp\DestroyAction;
use App\UseCases\AllowedIp\SearchAction;

class SquidAllowedIpController extends Controller
{
    public function search(SearchRequest $request, SearchAction $action)
    {
        return view('squidallowedips.search', [
            'ips'=>$action($request->searchSquidAllowedIp()),
        ]);
    }

    public function creator()
    {
        return view('squidallowedips.creator');
    }

    public function create(CreateRequest $request, CreateAction $action)
    {
        $action($request->createSquidAllowedIp());

        return redirect()->route('ip.search', $request->user()->id);
    }

    public function destroy(DestroyRequest $request, DestroyAction $action)
    {
        $action($request->destroySquidAllowedIp());

        return redirect()->route('ip.search', $request->user()->id);
    }
}
