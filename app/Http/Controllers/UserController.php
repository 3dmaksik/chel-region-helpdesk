<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\UsersAction;
use App\Requests\UserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    private UsersAction $users;
    public function __construct(UsersAction $users)
    {
        $this->middleware('auth');
        $this->middleware(['role:superAdmin']);
        $this->users = $users;
    }

    public function index(): View
    {
        $items = $this->users->getAllPagesPaginate();
        return view('tables.users', compact('items'));
    }

    public function show(int $work): View
    {
        $item = $this->users->show($work);
        return view('forms.show.users', compact('item'));
    }

    public function create(): View
    {
        $items = $this->users->create();
        return view('forms.add.users', compact('items'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $this->users->store($request->validated());
        return redirect()->route(config('constants.users.index'));
    }

    public function edit(int $user): View
    {
        $items = $this->users->edit($user);
        return view('forms.edit.users', compact('items'));
    }

    public function update(UserRequest $request, int $user): RedirectResponse
    {
        $item = $this->users->update($request->validated(), $user);
        return redirect()->route(config('constants.users.index'), $item);
    }

    public function destroy(int $user): RedirectResponse
    {
        $this->users->delete($user);
        return redirect()->route(config('constants.users.index'));
    }
}
