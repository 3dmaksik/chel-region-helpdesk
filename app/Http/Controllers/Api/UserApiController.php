<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\UsersAction;
use App\Models\User;
use App\Requests\User\StoreRequest;
use App\Requests\User\UpdatePasswordRequest;
use App\Requests\User\UpdateRequest;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    /**
     * [add new user]
     */
    public function store(StoreRequest $request, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->store($request->validated(null, null));

        return $this->data;
    }

    /**
     * [update user]
     */
    public function update(UpdateRequest $request, User $user, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->update($request->validated(null, null), $user);

        return $this->data;
    }

    /**
     * [update password for other user]
     */
    public function updatePassword(UpdatePasswordRequest $request, User $user, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->updatePassword($request->validated(null, null), $user);

        return $this->data;
    }

    /**
     * [delete other user]
     */
    public function destroy(User $user, UsersAction $usersAction): JsonResponse
    {
        $this->data = $usersAction->destroy($user);

        return $this->data;
    }
}
