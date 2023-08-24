<?php

declare(strict_types=1);

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Catalogs\Actions\Status;
use Carbon\Carbon;

final class HelpDTO extends DTO
{
    public readonly ?string $appNumber;

    public readonly ?int $category;

    public readonly ?Status $status;

    public readonly ?int $user;

    public readonly ?string $descriptionLong;

    public readonly ?Carbon $calendarRequest;

    public readonly ?bool $checkWrite;

    public readonly ?int $executor;

    public readonly ?int $priority;

    public readonly ?array $images;

    public readonly ?array $imagesFinal;

    public readonly ?string $info;

    public readonly ?string $infoFinal;

    public readonly ?Carbon $calendarAccept;

    public readonly ?Carbon $calendarWarning;

    public readonly ?Carbon $calendarExecution;

    public readonly ?Carbon $calendarFinal;

    public readonly ?int $leadAt;

    public function __construct(
        mixed ...$params,

    ) {
        $this->appNumber = $params['number'] ?? null;
        $this->category = $params['category'] ?? null;
        $this->status = $params['status'] ?? null;
        $this->user = $params['user'] ?? null;
        $this->descriptionLong = $params['description_long'] ?? null;
        $this->calendarRequest = $params['request'] ?? null;
        $this->checkWrite = $params['check_write'] ?? false;
        $this->executor = $params['executor'] ?? null;
        $this->priority = $params['priority'] ?? null;
        $this->images = $params['images'] ?? null;
        $this->imagesFinal = $params['images_final'] ?? null;
        $this->info = $params['info'] ?? null;
        $this->infoFinal = $params['info_final'] ?? null;
        $this->calendarAccept = $params['accept'] ?? null;
        $this->calendarWarning = $params['warning'] ?? null;
        $this->calendarExecution = $params['execution'] ?? null;
        $this->calendarFinal = $params['calendar_final'] ?? null;
        $this->leadAt = $params['lead_at'] ?? null;
    }
}
