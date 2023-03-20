<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Catalogs\Actions\UsersAction;
use Illuminate\View\View;

class UserController extends Controller
{
    private UsersAction $users;
    public function __construct(UsersAction $users)
    {
        $this->users = $users;
    }

    public function index(): View
    {
        $items = $this->users->getAllPagesPaginate();
        return view('tables.users', compact('items'));
    }

    public function create(): View
    {
        $items = $this->users->create();
        return view('forms.add.users', compact('items'));
    }

    public function edit(int $user): View
    {
        $items = $this->users->edit($user);
        return view('forms.edit.users', compact('items'));
    }

    public function show(int $user): View
    {
        $item = $this->users->show($user);
        return view('forms.show.user', compact('item'));
    }
}
