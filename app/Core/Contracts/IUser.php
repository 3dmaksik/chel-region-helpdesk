<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface IUser
{
    public function updatePassword(array $request, int $id): \Illuminate\Http\JsonResponse;

    public function edit(int $id): array;
}
