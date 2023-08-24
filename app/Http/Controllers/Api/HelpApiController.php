<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\HelpRequest;
use Illuminate\Http\JsonResponse;

final class HelpApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(HelpRequest $request, HelpAction $helps): JsonResponse
    {
        $this->data = $helps->store($request->validated(null, null));

        return $this->data;
    }

    public function update(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->update($request->validated(null, null), $help);

        return $this->data;
    }

    public function accept(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->accept($request->validated(null, null), $help);

        return $this->data;
    }

    public function execute(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->execute($request->validated(null, null), $help);

        return $this->data;
    }

    public function redefine(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->redefine($request->validated(null, null), $help);

        return $this->data;
    }

    public function reject(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->reject($request->validated(null, null), $help);

        return $this->data;
    }

    public function destroy(HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->destroy($help);

        return $this->data;
    }

    public function getApiCatalog(HelpAction $helps): JsonResponse
    {
        $this->data = $helps->getApiCatalog();

        return $this->data;
    }

    public function checkHelp(HelpAction $helps, int $id): JsonResponse
    {
        $this->data = $helps->updateView($id);

        return $this->data;
    }

    public function newPagesCount(HelpAction $helps): JsonResponse
    {
        $this->data = $helps->getNewPagesCount();

        return $this->data;
    }

    public function nowPagesCount(HelpAction $helps): JsonResponse
    {
        $this->data = $helps->getNowPagesCount();

        return $this->data;
    }

    /* public function getSoundNotify(): JsonResponse
     {
         $this->data = '/sound/sound.ogg';
         return response()->json($this->data);
     }
     */
}
