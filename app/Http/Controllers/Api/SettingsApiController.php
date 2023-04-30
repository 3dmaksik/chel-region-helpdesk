<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\SettingsAction;
use App\Requests\PasswordRequest;
use App\Requests\SettingsRequest;
use Illuminate\Http\JsonResponse;

class SettingsApiController extends Controller
{
    private JsonResponse $data;

    private SettingsAction $settings;

    public function __construct(SettingsAction $settings)
    {
        $this->settings = $settings;
    }

    public function updatePassword(PasswordRequest $request): JsonResponse
    {
        $this->data = $this->settings->updatePassword($request->validated());

        return $this->data;
    }

    public function updateSettings(SettingsRequest $request): JsonResponse
    {
        //DTO добавить и request
        $this->data = $this->settings->updateSettings($request->validated());

        return $this->data;
    }
}
