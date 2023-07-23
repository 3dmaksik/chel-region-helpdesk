<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\HelpRequest;
use Illuminate\Http\JsonResponse;

class HelpApiController extends Controller
{
    private string $dataCatalog;

    public function __construct(private readonly HelpAction $helps)
    {
        $this->middleware('auth');
    }

    public function store(HelpRequest $request): JsonResponse
    {
        $this->data = $this->helps->store($request);

        return $this->data;
    }

    public function update(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->update($request, $help);

        return $this->data;
    }

    public function accept(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->accept($request, $help);

        return $this->data;
    }

    public function execute(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->execute($request, $help);

        return $this->data;
    }

    public function redefine(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->redefine($request, $help);

        return $this->data;
    }

    public function reject(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->reject($request, $help);

        return $this->data;
    }

    public function destroy(int $help): JsonResponse
    {
        $this->data = $this->helps->delete($help);

        return $this->data;
    }

    public function getAllPages(): JsonResponse
    {
        $this->dataCatalog = $this->helps->getAllCatalogs()->toJson();

        return response()->json($this->dataCatalog);
    }

    public function checkHelp(int $id): JsonResponse
    {
        $this->data = $this->helps->updateView($id);

        return $this->data;
    }

    public function newPagesCount(): JsonResponse
    {
        $this->data = $this->helps->getNewPagesCount();

        return $this->data;
    }

    public function nowPagesCount(): JsonResponse
    {
        $this->data = $this->helps->getNowPagesCount();

        return $this->data;
    }

    /* public function getSoundNotify(): JsonResponse
     {
         $this->data = '/sound/sound.ogg';
         return response()->json($this->data);
     }
     */
}
