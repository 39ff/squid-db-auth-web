<?php

namespace App\Http\Controllers\Gui;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SquidAllowedIp\CreateRequest;
use App\Http\Requests\SquidAllowedIp\DestroyRequest;
use App\Http\Requests\SquidAllowedIp\SearchRequest;
use App\UseCases\AllowedIp\CreateAction;
use App\UseCases\AllowedIp\DestroyAction;
use App\UseCases\AllowedIp\SearchAction;

class SquidAllowedIpController extends Controller
{
    public function search(SearchRequest $request, SearchAction $action): View
    {
        return view('squidallowedips.search', [
            'ips'=>$action($request->searchSquidAllowedIp()),
        ]);
    }

    public function creator(): View
    {
        return view('squidallowedips.creator');
    }

    public function create(CreateRequest $request, CreateAction $action): RedirectResponse
    {
        $action($request->createSquidAllowedIp());

        return redirect()->route('ip.search', $request->user()->id);
    }

    public function destroy(DestroyRequest $request, DestroyAction $action): RedirectResponse
    {
        $action($request->destroySquidAllowedIp());

        return redirect()->route('ip.search', $request->user()->id);
    }
}
