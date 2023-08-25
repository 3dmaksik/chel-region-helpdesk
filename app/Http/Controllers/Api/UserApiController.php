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
     * [add new user]
     */
    public function store(UserRequest $request, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->store($request->validated(null, null));

        return $this->data;
    }

    /**
     * [update user]
     */
    public function update(UserRequest $request, int $user, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->update($request->validated(null, null), $user);

        return $this->data;
    }

    /**
     * [update password for other user]
     */
    public function updatePassword(PasswordRequest $request, int $user, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->updatePassword($request->validated(null, null), $user);

        return $this->data;
    }

    /**
     * [delete other user]
     */
    public function destroy(int $user, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->destroy($user);

        return $this->data;
    }
}
