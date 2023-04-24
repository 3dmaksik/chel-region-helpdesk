<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\UsersDTO;
use App\Models\User as Model;
use App\Requests\UserRequest;
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

    private array $dataClear;

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

    public function store(UserRequest $request): bool
    {
        $this->data = UsersDTO::storeObjectRequest($request);
        $this->dataClear = $this->clear($this->data);
        Model::create($this->dataClear)->assignRole($this->dataClear['role']);
        Model::flushQueryCache();

        return true;
    }

    public function update(UserRequest $request, int $id): Model
    {
        $this->user = Model::findOrFail($id);
        $this->data = UsersDTO::storeObjectRequest($request);
        $this->dataClear = $this->clear($this->data);
        $this->user->update($this->dataClear);
        $this->user->syncRoles($this->dataClear['role']);
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

    protected function clear(UsersDTO $data): array
    {
        return array_diff((array) $data, ['', null, false]);
    }
}
