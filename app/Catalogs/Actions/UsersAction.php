<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\UsersDTO;
use App\Models\User as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SimpleCollection;

class UsersAction extends Action
{
    private Model $user;

    private string $role;

    private SimpleCollection $roles;

    private SimpleCollection $cabinets;

    private array $users;

    private int $total;

    public function getAllPages(): Collection
    {
        $this->items = Model::orderBy('lastname', 'ASC')->get();

        return $this->items;
    }

    public function getAllPagesPaginate(): array
    {
        $this->items = Model::orderBy('lastname', 'ASC')->paginate($this->page);
        $this->total = Model::count();
        $this->users =
        [
            'data' => $this->items,
            'total' => $this->total,
        ];

        return $this->users;
    }

    public function create(): array
    {
        $this->roles = AllCatalogsDTO::getAllRolesCollection();
        $this->cabinets = AllCatalogsDTO::getAllCabinetCollection();

        return [
            'roles' => $this->roles,
            'cabinets' => $this->cabinets,
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
        $this->cabinets = AllCatalogsDTO::getAllCabinetCollection();

        return [
            'user' => $this->user,
            'roles' => $this->roles,
            'role' => $this->role,
            'cabinets' => $this->cabinets,
        ];
    }

    public function store(array $request): bool
    {
        $this->data = UsersDTO::storeObjectRequest($request);
        Model::create((array) $this->data)->assignRole($request['role']);
        Model::flushQueryCache();

        return true;
    }

    public function update(array $request, int $id): Model
    {
        $this->user = Model::findOrFail($id);
        $this->data = UsersDTO::storeObjectRequest($request);
        $this->user->update((array) $this->data);
        $this->user->syncRoles($request['role']);
        Model::flushQueryCache();

        return $this->user;
    }

    public function delete(int $id): bool
    {
        $this->user = Model::findOrFail($id);
        $this->user->syncRoles([]);
        $this->user->forceDelete();
        Model::flushQueryCache();

        return true;
    }

    public function getDataUser(): Model
    {
        return Model::whereId(auth()->user()->id)->first();
    }
}
