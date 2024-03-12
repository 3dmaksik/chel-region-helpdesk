<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface IHome
{
    public function getWorkerPagesPaginate(): array;

    public function getCompletedPagesPaginate(): array;

    public function getDismissPagesPaginate(): array;
}
