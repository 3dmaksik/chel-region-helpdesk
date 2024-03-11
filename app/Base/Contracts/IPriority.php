<?php

declare(strict_types=1);

namespace App\Base\Contracts;

interface IPriority
{
    public function getAllPagesPaginate(): array;

    public function show(\App\Models\Priority $model): array;

    public function store(array $request): \Illuminate\Http\JsonResponse;

    public function update(array $request, \App\Models\Priority $model): \Illuminate\Http\JsonResponse;

    public function destroy(\App\Models\Priority $model): \Illuminate\Http\JsonResponse;
}
