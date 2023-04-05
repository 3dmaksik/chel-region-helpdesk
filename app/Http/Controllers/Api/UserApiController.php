<?php

namespace App\Http\Controllers\Api;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\UsersAction;
use App\Requests\UserRequest;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    private string $data;

    private UsersAction $users;

    public function __construct(UsersAction $users)
    {
        $this->users = $users;
    }

    public function store(UserRequest $request): JsonResponse
    {
        $this->data = $this->users->store($request->validated());

        return response()->json($this->data);
    }

    public function update(UserRequest $request, int $user): JsonResponse
    {
        $this->data = $this->users->update($request->validated(), $user);

        return response()->json($this->data);
    }

    public function destroy(int $user): JsonResponse
    {
        $this->data = $this->users->delete($user);

        return response()->json($this->data);
    }

    public function users(): JsonResponse
    {
        $this->data = $this->users->getDataUser()->toJson();

        return response()->json($this->data);
    }
}
