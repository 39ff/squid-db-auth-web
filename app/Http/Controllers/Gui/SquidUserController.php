<?php

namespace App\Http\Controllers\Gui;

use App\Http\Controllers\Controller;
use App\Http\Requests\SquidUser\CreateRequest;
use App\Http\Requests\SquidUser\DestroyRequest;
use App\Http\Requests\SquidUser\ModifyRequest;
use App\Http\Requests\SquidUser\ReadRequest;
use App\Http\Requests\SquidUser\SearchRequest;
use App\Services\SquidUserService;
use App\UseCases\SquidUser\CreateAction;
use App\UseCases\SquidUser\DestroyAction;
use App\UseCases\SquidUser\ModifyAction;
use App\UseCases\SquidUser\SearchAction;
use Illuminate\Http\Request;

class SquidUserController extends Controller
{
    private $squidUserService;

    public function __construct(SquidUserService $squidUserService){
        $this->squidUserService = $squidUserService;
    }

    public function search(SearchRequest $request,SearchAction $action){
        return view('squidusers.search',[
            'users'=>$action($request->searchSquidUser())
        ]);
    }

    public function creator(){
        return view('squidusers.creator');
    }

    public function editor(ReadRequest $request){
        $squidUser = $this->squidUserService->getById($request->route()->parameter('id'));
        return view('squidusers.editor',[
            'id'=>$squidUser->id,
            'user'=>$squidUser->user,
            'password'=>$squidUser->password,
            'fullname'=>$squidUser->fullname,
            'comment'=>$squidUser->comment,
            'enabled'=>$squidUser->enabled
        ]);
    }

    public function modify(ModifyRequest $request,ModifyAction $action){
        $action($request->modifySquidUser());
        return redirect()->route('squiduser.search',$request->user()->id);
    }


    public function create(CreateRequest $request,CreateAction $action){
        $action($request->createSquidUser());
        return redirect()->route('squiduser.search',$request->user()->id);
    }

    public function destroy(DestroyRequest $request,DestroyAction $action){
        $action($request->destroySquidUser());
        return redirect()->route('squiduser.search',$request->user()->id);
    }
}