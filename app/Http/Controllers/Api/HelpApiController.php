<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\HelpRequest;
use Illuminate\Http\JsonResponse;

class HelpApiController extends Controller
{
    private string $data;
    private HelpAction $helps;
    public function __construct(HelpAction $helps)
    {
        $this->middleware('auth');
        $this->helps = $helps;
    }

    public function store(HelpRequest $request): JsonResponse
    {
        $this->data = $this->helps->store($request->validated());
        return response()->json($this->data);
    }

    public function update(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->update($request->validated(), $help);
        return response()->json($this->data);
    }

    public function accept(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->accept($request->validated(), $help);
        return response()->json($this->data);
    }

    public function execute(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->execute($request->validated(), $help);
        return response()->json($this->data);
    }

    public function redefine(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->redefine($request->validated(), $help);
        return response()->json($this->data);
    }

    public function reject(HelpRequest $request, int $help): JsonResponse
    {
        $this->data = $this->helps->reject($request->validated(), $help);
        return response()->json($this->data);
    }

    public function destroy(int $help): JsonResponse
    {
        $this->data = $this->helps->delete($help);
        return response()->json($this->data);
    }

    public function getAllPages(): JsonResponse
    {
        $this->data = $this->helps->getAllCatalogs()->toJson();
        return response()->json($this->data);
    }

    public function checkHelp(int $id): JsonResponse
    {
        $this->data = $this->helps->updateView($id);
        return response()->json($this->data);
    }

    public function newPagesCount(): JsonResponse
    {
        $this->data = $this->helps->getNewPagesCount();
        return response()->json($this->data);
    }

    public function nowPagesCount(): JsonResponse
    {
        $this->data = $this->helps->getNowPagesCount();
        return response()->json($this->data);
    }

   /* public function getSoundNotify(): JsonResponse
    {
        $this->data = '/sound/sound.ogg';
        return response()->json($this->data);
    }
    */
}
