<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\UsersAction;
use App\Requests\PasswordRequest;
use App\Requests\UserRequest;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    /**
     * [result data]
     */
    private JsonResponse $data;

    /**
     * [add new user]
     */
    public function store(UserRequest $request, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->store($request);

        return $this->data;
    }

    /**
     * [update user]
     */
    public function update(UserRequest $request, int $user, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->update($request, $user);

        return $this->data;
    }

    /**
     * [update password for other user]
     */
    public function updatePassword(PasswordRequest $request, int $user, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->updatePassword($request, $user);

        return $this->data;
    }

    /**
     * [delete other user]
     */
    public function destroy(int $user, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->delete($user);

        return $this->data;
    }
}
