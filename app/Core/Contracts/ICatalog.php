<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface ICatalog
{
    public function getAllPagesPaginate(): array;

    public function show(int $id): array;

    public function store(array $request): \Illuminate\Http\JsonResponse;

    public function update(array $request, int $id): \Illuminate\Http\JsonResponse;
}
