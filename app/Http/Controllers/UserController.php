<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\UsersAction;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * [all users]
     */
    public function index(UsersAction $usersAction): View
    {
        $items = $usersAction->getAllPagesPaginate();

        return view('tables.users', compact('items'));
    }

    /**
     * [new user]
     */
    public function create(UsersAction $usersAction): View
    {
        $items = $usersAction->create();

        return view('forms.add.users', compact('items'));
    }

    /**
     * [edit user]
     */
    public function edit(int $user, UsersAction $usersAction): View
    {
        $items = $usersAction->edit($user);

        return view('forms.edit.users', compact('items'));
    }

    /**
     * [show one user]
     */
    public function show(int $user, UsersAction $usersAction): View
    {
        $item = $usersAction->show($user);

        return view('forms.show.user', compact('item'));
    }
}
