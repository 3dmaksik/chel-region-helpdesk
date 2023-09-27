<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\HelpAction;
use App\Models\Help;
use App\Requests\Help\AcceptAdminRequest;
use App\Requests\Help\ExecuteAdminRequest;
use App\Requests\Help\RedefineAdminRequest;
use App\Requests\Help\RejectAdminRequest;
use App\Requests\Help\StoreAdminRequest;
use App\Requests\Help\UpdateAdminRequest;
use Illuminate\Http\JsonResponse;

final class HelpApiController extends Controller
{
    /**
     * [add new help]
     */
    public function store(StoreAdminRequest $request, HelpAction $helps): JsonResponse
    {
        $this->data = $helps->store($request->validated(null, null));

        return $this->data;
    }

    /**
     * [update help]
     */
    public function update(UpdateAdminRequest $request, HelpAction $helps, Help $help): JsonResponse
    {
        $this->data = $helps->update($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [accept help]
     */
    public function accept(AcceptAdminRequest $request, HelpAction $helps, Help $help): JsonResponse
    {
        $this->data = $helps->accept($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [execute help]
     */
    public function execute(ExecuteAdminRequest $request, HelpAction $helps, Help $help): JsonResponse
    {
        $this->data = $helps->execute($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [redefine help]
     */
    public function redefine(RedefineAdminRequest $request, HelpAction $helps, Help $help): JsonResponse
    {
        $this->data = $helps->redefine($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [reject help]
     */
    public function reject(RejectAdminRequest $request, HelpAction $helps, Help $help): JsonResponse
    {
        $this->data = $helps->reject($request->validated(null, null), $help);

        return $this->data;
    }

    /**
     * [remove help]
     */
    public function destroy(HelpAction $helps, Help $help): JsonResponse
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
     */
    public function checkHelp(HelpAction $helps, Help $id): JsonResponse
    {
        $this->data = $helps->updateView($id);

        return $this->data;
    }

    /**
     * [get new help count]
     */
    public function newPagesCount(HelpAction $helps): JsonResponse
    {
        $this->data = $helps->getNewPagesCount();

        return $this->data;
    }

    /**
     * [get now help count]
     */
    public function nowPagesCount(HelpAction $helps): JsonResponse
    {
        $this->data = $helps->getNowPagesCount();

        return $this->data;
    }
}
