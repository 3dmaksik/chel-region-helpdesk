<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\SettingsAction;
use App\Requests\Settings\UpdateSettingsRequest;
use App\Requests\Settings\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;

final class SettingsApiController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request, SettingsAction $settingsAction): JsonResponse
    {
        $this->data = $settingsAction->updatePassword($request->validated(null, null));

        return $this->data;
    }

    public function updateSettings(UpdateSettingsRequest $request, SettingsAction $settingsAction): JsonResponse
    {
        $this->data = $settingsAction->updateSettings($request->validated(null, null));

        return $this->data;
    }
}
