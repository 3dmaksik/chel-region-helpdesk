<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface ICatalogExtented
{
    public function destroy(int $id): \Illuminate\Http\JsonResponse;
}
