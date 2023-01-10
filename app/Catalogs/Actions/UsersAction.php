<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\UsersDTO;
use App\Models\User as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SimpleCollection;

class UsersAction extends Action
{
    private Model $user;
    private string $role;
    private SimpleCollection $roles;
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
        $this->roles = AllCatalogsDTO::getAllRolesCollection();
        return [
            'roles' => $this->roles,
        ];
    }

    public function show(int $id): Model
    {
        $this->user = Model::findOrFail($id);
        return $this->user;
    }

    public function edit(int $id): array
    {
        $this->user = Model::findOrFail($id);
        $this->roles = AllCatalogsDTO::getAllRolesCollection();
        $this->role = $this->user->getRoleNames()[0];
        return [
            'user' => $this->user,
            'roles' => $this->roles,
            'role' => $this->role,
        ];
    }

    public function store(array $request) : bool
    {
        $this->data = UsersDTO::storeObjectRequest($request);
        Model::create((array) $this->data)->assignRole($request['role']);
        Model::flushQueryCache();
        return true;
    }

    public function update(array $request, int $id) : Model
    {
        $this->user = Model::findOrFail($id);
        $this->data = UsersDTO::storeObjectRequest($request);
        $this->user->update((array) $this->data);
        $this->user->syncRoles($request['role']);
        Model::flushQueryCache();
        return $this->user;
    }

    public function delete(int $id) : bool
    {
        $this->user = Model::findOrFail($id);
        $this->user->syncRoles([]);
        $this->user->forceDelete();
        Model::flushQueryCache();
        return true;
    }
}
