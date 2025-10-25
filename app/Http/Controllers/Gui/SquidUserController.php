<?php

namespace App\Http\Controllers\Gui;

use App\Http\Controllers\Controller;
use App\Http\Requests\SquidUser\BulkImportRequest;
use App\Http\Requests\SquidUser\CreateRequest;
use App\Http\Requests\SquidUser\DestroyRequest;
use App\Http\Requests\SquidUser\ModifyRequest;
use App\Http\Requests\SquidUser\ReadRequest;
use App\Http\Requests\SquidUser\SearchRequest;
use App\Services\SquidUserService;
use App\UseCases\SquidUser\BulkCreateAction;
use App\UseCases\SquidUser\BulkDeleteAction;
use App\UseCases\SquidUser\BulkUpdateAction;
use App\UseCases\SquidUser\CreateAction;
use App\UseCases\SquidUser\DestroyAction;
use App\UseCases\SquidUser\ModifyAction;
use App\UseCases\SquidUser\SearchAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SquidUserController extends Controller
{
    public function __construct(
        private readonly SquidUserService $squidUserService
    ) {
    }

    public function search(SearchRequest $request, SearchAction $action): View
    {
        return view('squidusers.search', [
            'users'=>$action($request->searchSquidUser()),
        ]);
    }

    public function creator(): View
    {
        return view('squidusers.creator');
    }

    public function editor(ReadRequest $request): View
    {
        $squidUser = $this->squidUserService->getById($request->route()->parameter('id'));

        return view('squidusers.editor', [
            'id'=>$squidUser->id,
            'user'=>$squidUser->user,
            'password'=>$squidUser->password,
            'fullname'=>$squidUser->fullname,
            'comment'=>$squidUser->comment,
            'enabled'=>$squidUser->enabled,
        ]);
    }

    public function modify(ModifyRequest $request, ModifyAction $action): RedirectResponse
    {
        $action($request->modifySquidUser());

        return redirect()->route('squiduser.search', $request->user()->id);
    }

    public function create(CreateRequest $request, CreateAction $action): RedirectResponse
    {
        $action($request->createSquidUser());

        return redirect()->route('squiduser.search', $request->user()->id);
    }

    public function destroy(DestroyRequest $request, DestroyAction $action): RedirectResponse
    {
        $action($request->destroySquidUser());

        return redirect()->route('squiduser.search', $request->user()->id);
    }

    public function bulkImporter(): View
    {
        return view('squidusers.bulk_import');
    }

    public function bulkImport(BulkImportRequest $request): RedirectResponse
    {
        $rows = $request->parseCsv();
        $operation = $request->input('operation');
        $userId = $request->user()->id;

        $results = match ($operation) {
            'create' => (new BulkCreateAction())($rows, $userId),
            'update' => (new BulkUpdateAction())($rows, $userId),
            'delete' => (new BulkDeleteAction())($rows, $userId),
            default => ['success' => 0, 'failed' => 0, 'errors' => ['Invalid operation']],
        };

        $message = "Success: {$results['success']}, Failed: {$results['failed']}";
        if (!empty($results['errors'])) {
            $message .= "\nErrors: " . implode("\n", $results['errors']);
        }

        return redirect()
            ->route('squiduser.bulk.importer')
            ->with('message', $message)
            ->with('results', $results);
    }
}
