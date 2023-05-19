<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Requests\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection as SimpleCollection;

final class HelpDTO extends DTO
{
    public ?int $category_id;

    public ?int $executor_id;

    public ?int $priority_id;

    public ?int $user_id;

    public ?int $status_id;

    public ?string $description_long;

    public ?string $info;

    public ?string $info_final;

    public ?string $images;

    public ?string $images_final;

    public ?string $app_number;

    public ?Carbon $calendar_warning;

    public ?Carbon $calendar_final;

    public ?Carbon $calendar_accept;

    public ?Carbon $calendar_execution;

    public ?Carbon $calendar_request;

    public ?bool $check_write;

    public static function storeObjectRequest(Request $request, ?SimpleCollection $options = null): self
    {
        $dto = new self();
        $dto->category_id = $request->get('category_id');
        $dto->priority_id = $request->get('priority_id');
        $dto->user_id = $request->get('user_id');
        $dto->executor_id = $request->get('executor_id');
        $dto->description_long = $request->get('description_long');
        $dto->info = $request->get('info');
        $dto->info_final = $request->get('info_final');
        $dto->images = $options?->get('images');
        $dto->images_final = $options?->get('images_final');
        $dto->app_number = $options?->get('app_number');
        $dto->status_id = $options?->get('status_id');
        $dto->calendar_request = $options?->get('calendar_request');
        $dto->calendar_accept = $options?->get('calendar_accept');
        $dto->calendar_warning = $options?->get('calendar_warning');
        $dto->calendar_execution = $options?->get('calendar_execution');
        $dto->calendar_final = $options?->get('calendar_final');
        $dto->check_write = $options?->get('check_write');

        return $dto;
    }
}
