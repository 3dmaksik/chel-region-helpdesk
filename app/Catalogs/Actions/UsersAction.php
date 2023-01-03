<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\UsersDTO;
use App\Models\User as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UsersAction extends Action
{
    private Model $user;
    public function getAllPages() : Collection
    {
        $this->items = Model::select('id', 'name')->orderBy('name', 'ASC')->get();
        return $this->items;
    }

    public function getAllPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::select('id', 'name')->orderBy('name', 'ASC')->paginate($this->page);
        return $this->items;
    }

    public function create() : array
    {
        $roles = AllCatalogsDTO::getAllRolesCollection();
        return [
            'roles' => $roles,
        ];
    }

    public function show(int $id): array
    {
        $this->user = Model::findOrFail($id);
        $role = $this->user->getRoleNames();
        return [
            'user' => $this->user,
            'role' => $role,
        ];
    }

    public function edit(int $id): array
    {
        $this->user = Model::findOrFail($id);
        $roles = AllCatalogsDTO::getAllRolesCollection();
        $role = $this->user->getRoleNames();
        return [
            'user' => $this->user,
            'roles' => $roles,
            'role' => $role,
        ];
    }

    public function store(array $request) : bool
    {
        $data = UsersDTO::storeObjectRequest($request);
        Model::create((array) $data)->assignRole($request['role']);
        Model::flushQueryCache();
        return true;
    }

    public function update(array $request, int $id) : Model
    {
        $this->user = Model::findOrFail($id);
        $data = UsersDTO::storeObjectRequest($request);
        $this->user->update((array) $data);
        $this->user->assignRole($request['role']);
        Model::flushQueryCache();
        return $this->user;
    }

    public function delete(int $id) : bool
    {
        $this->user = Model::findOrFail($id);
        $this->user->forceDelete();
        Model::flushQueryCache();
        return true;
    }
}
