<?php

namespace App\Http\Controllers\Gui;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\DestroyRequest;
use App\Http\Requests\User\ModifyRequest;
use App\Http\Requests\User\ReadRequest;
use App\Http\Requests\User\SearchRequest;
use App\Services\UserService;
use App\UseCases\User\CreateAction;
use App\UseCases\User\DestroyAction;
use App\UseCases\User\ModifyAction;
use App\UseCases\User\SearchAction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function create(CreateRequest $request, CreateAction $action)
    {
        $action($request->createUser());

        return redirect()->route('user.search');
    }

    public function modify(ModifyRequest $request, ModifyAction $action)
    {
        $action($request->modifyUser());

        return redirect()->route('user.search');
    }

    public function editor(ReadRequest $request)
    {
        $user = $this->user->getById($request->route()->parameter('id'));

        return view('users.editor', [
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
        ]);
    }

    public function creator()
    {
        return view('users.creator');
    }

    public function destroy(DestroyRequest $request, DestroyAction $action)
    {
        $action($request->destroyUser());

        return back();
    }

    public function search(SearchRequest $request, SearchAction $action)
    {
        return view('users.search', [
            'users'=>$action($request->searchUser()),
        ]);
    }
}
