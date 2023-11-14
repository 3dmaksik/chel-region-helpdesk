<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Enums\Status;
use App\Core\Contracts\IHome;
use App\Models\Help as Model;

class HomeAction extends Action implements IHome
{
    /**
     * [items help data paginate]
     *
     * @var helps
     */
    private array $helps;

    /**
     * [worker helps with count items on page]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getWorkerPagesPaginate(): array
    {
        $this->items = Model::where('status_id', '<', Status::Success)
            ->where('user_id', auth()->user()->id)
            ->orderBy('status_id', 'ASC')
            ->orderBy('calendar_final', 'DESC')
            ->orderByRaw('CASE WHEN calendar_execution IS NULL THEN 0 ELSE 1 END ASC')
            ->orderByRaw('CASE WHEN calendar_warning IS NULL THEN 0 ELSE 1 END ASC')
            ->orderBy('calendar_warning', 'DESC')
            ->orderBy('calendar_accept', 'DESC')
            ->orderBy('calendar_execution', 'DESC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'workeruser',
            'data' => $this->items,
        ];

        return $this->helps;
    }

    /**
     * [completed helps with count items on page]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getCompletedPagesPaginate(): array
    {
        $this->items = Model::where('status_id', Status::Success)
            ->where('user_id', auth()->user()->id)
            ->orderBy('calendar_final', 'DESC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'completeduser',
            'data' => $this->items,
        ];

        return $this->helps;
    }

    /**
     * [danger helps with count items on page]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getDismissPagesPaginate(): array
    {
        $this->items = Model::where('status_id', Status::Danger)
            ->where('user_id', auth()->user()->id)
            ->orderBy('calendar_request', 'DESC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'dismissuser',
            'data' => $this->items,
        ];

        return $this->helps;
    }
}
