<?php

declare(strict_types=1);

namespace App\Base\Contracts;

interface ISettings
{
    public function updateSettings(array $request): \Illuminate\Http\JsonResponse;

    public function updatePassword(array $request): \Illuminate\Http\JsonResponse;
}
