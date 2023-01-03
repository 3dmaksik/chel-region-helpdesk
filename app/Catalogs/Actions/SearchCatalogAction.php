<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchCatalogAction extends Action
{
    public function __construct()
    {
        //parent::__construct();
    }

    public function searchHelpWork(int $id): LengthAwarePaginator
    {
        $this->items = Help::where('work_id', $id)->paginate($this->page);
        return $this->items;
    }

    public function searchHelpCategory(int $id): LengthAwarePaginator
    {
        $this->items = Help::where('category_id', $id)->paginate($this->page);
        return $this->items;
    }

    public function searchHelpCabinet(int $id): LengthAwarePaginator
    {
        $this->items = Help::join('work', 'work.id', '=', 'help.work_id')->where('work.cabinet_id', $id)->paginate($this->page);
        return $this->items;
    }

    public function searchHelp(array $request): LengthAwarePaginator
    {
        $item = $request['search'];
        $this->items = Help::join('work', 'work.id', '=', 'help.work_id')
        ->join('category', 'category.id', '=', 'help.category_id')
        ->join('status', 'status.id', '=', 'help.status_id')
        ->join('cabinet', 'cabinet.id', '=', 'work.cabinet_id')
        ->join('priority', 'priority.id', '=', 'help.priority_id')
        ->where('description_long', 'LIKE', '%' . $item . '%')
        ->orWhere('category.description', 'LIKE', '%' . $item . '%')
        ->orWhere('status.description', 'LIKE', '%' . $item . '%')
        ->orWhere('cabinet.description', 'LIKE', '%' . $item . '%')
        ->orWhere('priority.description', 'LIKE', '%' . $item . '%')
        ->orWhere('info', 'LIKE', '%' . $item . '%')
        ->orWhere('info_final', 'LIKE', '%' . $item . '%')
        ->orWhere('work.firstname', 'LIKE', '%' . $item . '%')
        ->orWhere('work.lastname', 'LIKE', '%' . $item . '%')
        ->orWhere('work.patronymic', 'LIKE', '%' . $item . '%')
        ->paginate($this->page);
        return $this->items;
    }
}
