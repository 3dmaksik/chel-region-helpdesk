<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Requests\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection as SimpleCollection;

final class HelpDTO extends DTO
{
    public ?int $category_id = null;

    public ?int $executor_id = null;

    public ?int $priority_id = null;

    public ?int $user_id = null;

    public ?int $status_id = null;

    public ?string $description_long = null;

    public ?string $info = null;

    public ?string $info_final = null;

    public ?string $images = null;

    public ?string $images_final = null;

    public ?string $app_number = null;

    public ?Carbon $calendar_warning = null;

    public ?Carbon $calendar_final = null;

    public ?Carbon $calendar_accept = null;

    public ?Carbon $calendar_execution = null;

    public ?Carbon $calendar_request = null;

    public ?int $lead_at = null;

    public ?bool $check_write = null;

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
        $dto->lead_at = $options?->get('lead_at');
        $dto->calendar_final = $options?->get('calendar_final');
        $dto->check_write = $options?->get('check_write');

        return $dto;
    }
}
