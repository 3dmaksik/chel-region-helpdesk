<?php

namespace App\Core\Contracts;

interface ICabinet
{
    /**
     * @return array{data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array;

    public function show(int $id): \App\Models\Cabinet;

    /**
     * @param array $request {description: int}
     */
    public function store(array $request): \Illuminate\Http\JsonResponse;

    /**
     * @param array $request {description: int}
     */
    public function update(array $request, int $id): \Illuminate\Http\JsonResponse;

    public function destroy(int $id): \Illuminate\Http\JsonResponse;
}
