<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Requests\HelpRequest;
use Illuminate\Http\JsonResponse;

final class HelpApiController extends Controller
{
    /**
     * [add new help]
     *
     */
    public function store(HelpRequest $request, HelpAction $helps): JsonResponse
    {
        $this->data = $helps->store($request->validated(null, null));

        return $this->data;
    }

    /**
     * [update help]
     *
     */
    public function update(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->update($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [accept help]
     *
     */
    public function accept(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->accept($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [execute help]
     *
     */
    public function execute(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->execute($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [redefine help]
     *
     */
    public function redefine(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->redefine($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [reject help]
     *
     */
    public function reject(HelpRequest $request, HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->reject($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [remove help]
     *
     */
    public function destroy(HelpAction $helps, int $help): JsonResponse
    {
        $this->data = $helps->destroy($help);

        return $this->data;
    }

    /**
     * [get api for form help]
     */
    public function getApiCatalog(HelpAction $helps): JsonResponse
    {
        $this->data = $helps->getApiCatalog();

        return $this->data;
    }

     /**
     * [writable help]
     *
     */
    public function checkHelp(HelpAction $helps, int $id): JsonResponse
    {
        $this->data = $helps->updateView($id);

        return $this->data;
    }

     /**
     * [get new help count]
     *
     */
    public function newPagesCount(HelpAction $helps): JsonResponse
    {
        $this->data = $helps->getNewPagesCount();

        return $this->data;
    }

     /**
     * [get now help count]
     *
     */
    public function nowPagesCount(HelpAction $helps): JsonResponse
    {
        $this->data = $helps->getNowPagesCount();

        return $this->data;
    }
}
