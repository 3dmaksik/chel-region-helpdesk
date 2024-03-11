<?php

declare(strict_types=1);

namespace App\Base\Contracts;

interface IArticle
{
    public function getAllPagesPaginate(): array;

    public function show(\App\Models\Article $model): array;

    public function store(array $request): \Illuminate\Http\JsonResponse;

    public function update(array $request, \App\Models\Article $model): \Illuminate\Http\JsonResponse;

    public function destroy(\App\Models\Article $model): \Illuminate\Http\JsonResponse;
}
