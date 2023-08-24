<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface IHelp
{
    public function getNewPagesPaginate(): array;

    public function getWorkerPagesPaginate(): array;

    public function getCompletedPagesPaginate(): array;

    public function getDismissPagesPaginate(): array;

    public function create(): mixed;

    public function edit(int $id): array;

    public function accept(array $request, int $id): \Illuminate\Http\JsonResponse;

    public function execute(array $request, int $id): \Illuminate\Http\JsonResponse;

    public function redefine(array $request, int $id): \Illuminate\Http\JsonResponse;

    public function reject(array $request, int $id): \Illuminate\Http\JsonResponse;

    public function updateView(int $id, bool $status): \Illuminate\Http\JsonResponse;

    public function getNewPagesCount(): \Illuminate\Http\JsonResponse;

    public function getNowPagesCount(): \Illuminate\Http\JsonResponse;

}
