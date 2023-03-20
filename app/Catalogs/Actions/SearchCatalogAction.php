<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchCatalogAction extends Action
{
    protected User $user;
    private LengthAwarePaginator $helpSearch;
    private array $searchData;
    public function __construct()
    {
        parent::__construct();
    }
        //не работает ещё
    protected function role(Builder $builder) : Builder
    {
        $this->user = User::whereId(auth()->user()->id)->first();
        if ($this->user->hasRole('user')) {
            return $builder->where('user_id', auth()->user()->id);
        }
        if ($this->user->hasRole('manager')) {
            return $builder->where('user_id', auth()->user()->id)
            ->where('executor_id', auth()->user()->id);
        }
    }

    public function searchHelpWork(int $id): array
    {
        $this->helpSearch = Help::where('user_id', $id)->RoleSearch()->paginate($this->page);
        $this->searchData =
        [
            'method' => 'searchwork',
            'data' => $this->helpSearch,
        ];
        return $this->searchData;
    }

    public function searchHelpCategory(int $id): array
    {
        $this->helpSearch = Help::where('category_id', $id)->RoleSearch()->paginate($this->page);
        $this->searchData =
        [
            'method' => 'searchcategory',
            'data' => $this->helpSearch,
        ];
        return $this->searchData;
    }

    public function searchHelpCabinet(int $id): array
    {
        $this->helpSearch =
        Help::join('users', 'users.id', '=', 'help.user_id')->RoleSearch()->where('users.cabinet_id', $id)->paginate($this->page);
        $this->searchData =
        [
            'method' => 'searchcabinet',
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
        ->where('app_number', 'LIKE', '%' . $item . '%')
        ->orWhere('description_long', 'LIKE', '%' . $item . '%')
        ->orWhere('category.description', 'LIKE', '%' . $item . '%')
        ->orWhere('status.description', 'LIKE', '%' . $item . '%')
        ->orWhere('cabinet.description', 'LIKE', '%' . $item . '%')
        ->orWhere('priority.description', 'LIKE', '%' . $item . '%')
        ->orWhere('info', 'LIKE', '%' . $item . '%')
        ->orWhere('info_final', 'LIKE', '%' . $item . '%')
        ->orWhere('users.firstname', 'LIKE', '%' . $item . '%')
        ->orWhere('users.lastname', 'LIKE', '%' . $item . '%')
        ->orWhere('users.patronymic', 'LIKE', '%' . $item . '%')
        ->paginate($this->page);
        $this->helpSearch->appends(array('search' => $item));
        $this->searchData =
        [
            'method' => 'searchcall',
            'data' => $this->helpSearch,
        ];
        return $this->searchData;
    }
}
