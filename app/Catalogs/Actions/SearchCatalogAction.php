<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchCatalogAction extends Action
{
    protected User $user;

    private LengthAwarePaginator $helpSearch;

    private array $searchData;

    private int $total;

    public function __construct()
    {
        parent::__construct();
    }

    public function searchHelpWork(int $id): array
    {
        $this->helpSearch = Help::where('user_id', $id)->RoleSearch()->paginate($this->page);
        $this->total = Help::where('user_id', $id)->RoleSearch()->count();
        $this->searchData =
        [
            'method' => 'searchwork',
            'total' => $this->total,
            'data' => $this->helpSearch,
        ];

        return $this->searchData;
    }

    public function searchHelpCategory(int $id): array
    {
        $this->helpSearch = Help::where('category_id', $id)->RoleSearch()->paginate($this->page);
        $this->total = Help::where('category_id', $id)->RoleSearch()->count();
        $this->searchData =
        [
            'method' => 'searchcategory',
            'total' => $this->total,
            'data' => $this->helpSearch,
        ];

        return $this->searchData;
    }

    public function searchHelpCabinet(int $id): array
    {
        $this->helpSearch =
        Help::join('users', 'users.id', '=', 'help.user_id')->RoleSearch()->where('users.cabinet_id', $id)->paginate($this->page);
        $this->total =
        Help::join('users', 'users.id', '=', 'help.user_id')->RoleSearch()->where('users.cabinet_id', $id)->count();
        $this->searchData =
        [
            'method' => 'searchcabinet',
            'total' => $this->total,
            'data' => $this->helpSearch,
        ];

        return $this->searchData;
    }

    public function searchHelp(array $request): array
    {
        $item = $request['search'];
        $this->helpSearch = Help::join('users', 'users.id', '=', 'help.user_id')
            ->join('category', 'category.id', '=', 'help.category_id')
            ->join('status', 'status.id', '=', 'help.status_id')
            ->join('cabinet', 'cabinet.id', '=', 'users.cabinet_id')
            ->join('priority', 'priority.id', '=', 'help.priority_id')
            ->RoleSearch()
            ->where('app_number', 'LIKE', '%'.$item.'%')
            ->orWhere('description_long', 'LIKE', '%'.$item.'%')
            ->orWhere('category.description', 'LIKE', '%'.$item.'%')
            ->orWhere('status.description', 'LIKE', '%'.$item.'%')
            ->orWhere('cabinet.description', 'LIKE', '%'.$item.'%')
            ->orWhere('priority.description', 'LIKE', '%'.$item.'%')
            ->orWhere('info', 'LIKE', '%'.$item.'%')
            ->orWhere('info_final', 'LIKE', '%'.$item.'%')
            ->orWhere('users.firstname', 'LIKE', '%'.$item.'%')
            ->orWhere('users.lastname', 'LIKE', '%'.$item.'%')
            ->orWhere('users.patronymic', 'LIKE', '%'.$item.'%')
            ->paginate($this->page);
        $this->total = Help::join('users', 'users.id', '=', 'help.user_id')
            ->join('category', 'category.id', '=', 'help.category_id')
            ->join('status', 'status.id', '=', 'help.status_id')
            ->join('cabinet', 'cabinet.id', '=', 'users.cabinet_id')
            ->join('priority', 'priority.id', '=', 'help.priority_id')
            ->RoleSearch()
            ->where('app_number', 'LIKE', '%'.$item.'%')
            ->orWhere('description_long', 'LIKE', '%'.$item.'%')
            ->orWhere('category.description', 'LIKE', '%'.$item.'%')
            ->orWhere('status.description', 'LIKE', '%'.$item.'%')
            ->orWhere('cabinet.description', 'LIKE', '%'.$item.'%')
            ->orWhere('priority.description', 'LIKE', '%'.$item.'%')
            ->orWhere('info', 'LIKE', '%'.$item.'%')
            ->orWhere('info_final', 'LIKE', '%'.$item.'%')
            ->orWhere('users.firstname', 'LIKE', '%'.$item.'%')
            ->orWhere('users.lastname', 'LIKE', '%'.$item.'%')
            ->orWhere('users.patronymic', 'LIKE', '%'.$item.'%')->count();
        $this->helpSearch->appends(['search' => $item]);
        $this->searchData =
        [
            'method' => 'searchcall',
            'total' => $this->total,
            'data' => $this->helpSearch,
        ];

        return $this->searchData;
    }
}
