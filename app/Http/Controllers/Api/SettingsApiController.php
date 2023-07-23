<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\SettingsAction;
use App\Requests\AccountRequest;
use App\Requests\PasswordRequest;
use Illuminate\Http\JsonResponse;

class SettingsApiController extends Controller
{
    public function updatePassword(PasswordRequest $request, SettingsAction $settingsAction): JsonResponse
    {
        $this->data = $settingsAction->updatePassword($request->validated(null, null));

        return $this->data;
    }

    public function updateSettings(AccountRequest $request, SettingsAction $settingsAction): JsonResponse
    {
        $this->data = $settingsAction->updateSettings($request);

        return $this->data;
    }
}
