<?php

namespace App\Search\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\SearchCatalogsDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchCatalogAction extends Action
{
    public function __construct()
    {
        //parent::__construct();
    }

    public function searchCatalog(SearchCatalogsDTO $config): LengthAwarePaginator
    {
        //Запуск репозитория
        return $config->model->where($config->field, $config->id)->paginate($config->pages);
    }

    public function searchHelp(string $item, int $pages): LengthAwarePaginator
    {
        //Запуск репозитория
        return $this->help
        ->join('work', 'work.id', '=', 'help.work_id')
        ->join('category', 'category.id', '=', 'help.category_id')
        ->join('status', 'status.id', '=', 'help.status_id')
        ->join('cabinet', 'cabinet.id', '=', 'help.cabinet_id')
        ->join('priority', 'priority.id', '=', 'help.priority_id')
        ->where('description_long', 'LIKE', '%' . $item . '%')
        ->orWhere('info', 'LIKE', '%' . $item . '%')
        ->orWhere('info_final', 'LIKE', '%' . $item . '%')
        ->orWhere('work.firstname', 'LIKE', '%' . $item . '%')
        ->orWhere('work.lastname', 'LIKE', '%' . $item . '%')
        ->orWhere('work.patronymic', 'LIKE', '%' . $item . '%')
        ->paginate($pages);
    }
}
