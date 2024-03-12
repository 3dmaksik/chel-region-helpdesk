<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface IUser
{
    public function getAllPagesPaginate(): array;

    public function show(\App\Models\User $model): array;

    public function edit(\App\Models\User $model): array;

    public function store(array $request): \Illuminate\Http\JsonResponse;

    public function update(array $request, \App\Models\User $model): \Illuminate\Http\JsonResponse;

    public function updatePassword(array $request, \App\Models\User $model): \Illuminate\Http\JsonResponse;

    public function destroy(\App\Models\User $model): \Illuminate\Http\JsonResponse;
}
