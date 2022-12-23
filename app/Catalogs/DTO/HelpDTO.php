<?php

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use App\Base\Helpers\StoreFilesHelper;
use App\Models\Help;
use Carbon\Carbon;

class HelpDTO extends DTO
{
    public int $category_id;
    public int $cabinet_id;
    public int $executor_id;
    public int $priority_id;
    public int $work_id;
    public int $status_id;
    public string $description_long;
    public string $info;
    public string $info_final;
    public string $images;
    public Carbon $calendar_warning;
    public Carbon $calendar_final;
    public Carbon $calendar_accept;
    public Carbon $calendar_execution;
    public bool $check_write;
    public static function storeObjectRequest(array $request): self
    {
        $dto = new self();
        if (isset($request['category_id'])) {
            $dto->category_id = $request['category_id'];
        }
        if (isset($request['cabinet_id'])) {
            $dto->cabinet_id = $request['cabinet_id'];
        }
        if (isset($request['priority_id'])) {
            $dto->priority_id = $request['priority_id'];
        }
        if (isset($request['work_id'])) {
            $dto->work_id = $request['work_id'];
        }
        if (isset($request['description_long'])) {
            $dto->description_long = $request['description_long'];
        }
        if (isset($request['images'])) {
            $dto->images = json_encode(StoreFilesHelper::createFile($request['images']));
        }
        $dto->calendar_request = Carbon::now();
        return $dto;
    }

    public static function acceptObjectRequest(array $request, int $id): self
    {
        $dto = new self();
        $help = Help::find($id);
        $dto->executor_id = $request['executor_id'];
        $dto->priority_id = $request['priority_id'];
        $dto->status_id = 1;
        ($request['info']) ? $dto->info = $request['info'] : $dto->info = 'Информация отсутствует';
        $dto->calendar_accept = Carbon::now();
        $dto->calendar_warning = Carbon::now()->addHour($help->priority->warning_timer);
        $dto->calendar_execution = Carbon::now()->addHour($help->priority->danger_timer);
        $dto->check_write = true;
        return $dto;
    }

    public static function executeObjectRequest(array $request): self
    {
        $dto = new self();
        $dto->status_id = 3;
        $dto->info_final = 'Выполнено с комментарием:' . $request['info_final'];
        $dto->calendar_final = Carbon::now();
        $dto->check_write = false;
        return $dto;
    }

    public static function redefineObjectRequest(array $request): self
    {
        $dto = new self();
        $dto->executor_id = $request['executor_id'];
        $dto->calendar_accept = Carbon::now();
        return $dto;
    }

    public static function rejectObjectRequest(array $request): self
    {
        $dto = new self();
        $dto->status_id = 4;
        $dto->info_final = 'Причина отклонения:' . $request['info_final'];
        $dto->calendar_final = Carbon::now();
        $dto->check_write = false;
        return $dto;
    }
}
