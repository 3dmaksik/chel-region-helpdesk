<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\UsersAction;
use App\Requests\UserRequest;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    private JsonResponse $data;

    private UsersAction $users;

    public function __construct(UsersAction $users)
    {
        $this->users = $users;
    }

    public function store(UserRequest $request): JsonResponse
    {
        $this->data = $this->users->store($request);

        return $this->data;
    }

    public function update(UserRequest $request, int $user): JsonResponse
    {
        $this->data = $this->users->update($request, $user);

        return $this->data;
    }

    public function destroy(int $user): JsonResponse
    {
        $this->data = $this->users->delete($user);

        return $this->data;
    }
}
