<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface ICategory
{
    public function getAllPagesPaginate(): array;

    public function show(\App\Models\Category $model): array;

    public function store(array $request): \Illuminate\Http\JsonResponse;

    public function update(array $request, \App\Models\Category $model): \Illuminate\Http\JsonResponse;

    public function destroy(\App\Models\Category $model): \Illuminate\Http\JsonResponse;
}
