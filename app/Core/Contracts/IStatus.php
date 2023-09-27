<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface IStatus
{
    public function getAllPagesPaginate(): array;

    public function show(\App\Models\Status $model): array;

    public function update(array $request, \App\Models\Status $model): \Illuminate\Http\JsonResponse;
}
