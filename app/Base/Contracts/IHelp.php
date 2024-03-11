<?php

declare(strict_types=1);

namespace App\Base\Contracts;

interface IHelp
{
    public function getAllPagesPaginate(): array;

    public function getNewPagesPaginate(): array;

    public function getWorkerPagesPaginate(): array;

    public function getCompletedPagesPaginate(): array;

    public function getDismissPagesPaginate(): array;

    public function create(): mixed;

    public function show(int $id): array;

    public function store(array $request): \Illuminate\Http\JsonResponse;

    public function update(array $request, \App\Models\Help $model): \Illuminate\Http\JsonResponse;

    public function accept(array $request, \App\Models\Help $model): \Illuminate\Http\JsonResponse;

    public function execute(array $request, \App\Models\Help $model): \Illuminate\Http\JsonResponse;

    public function redefine(array $request, \App\Models\Help $model): \Illuminate\Http\JsonResponse;

    public function reject(array $request, \App\Models\Help $model): \Illuminate\Http\JsonResponse;

    public function updateView(\App\Models\Help $model, bool $status): \Illuminate\Http\JsonResponse;

    public function getNewPagesCount(): \Illuminate\Http\JsonResponse;

    public function getNowPagesCount(): \Illuminate\Http\JsonResponse;
}
