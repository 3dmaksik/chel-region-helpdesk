<?php

declare(strict_types=1);

namespace App\Base\Contracts;

interface ICabinet
{
    public function getAllPagesPaginate(): array;

    public function show(\App\Models\Cabinet $model): array;

    public function store(array $request): \Illuminate\Http\JsonResponse;

    public function update(array $request, \App\Models\Cabinet $model): \Illuminate\Http\JsonResponse;

    public function destroy(\App\Models\Cabinet $model): \Illuminate\Http\JsonResponse;
}
