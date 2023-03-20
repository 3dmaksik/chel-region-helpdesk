<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Controller;
use App\Models\Cabinet;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:superAdmin']);
    }

    public function index(): View
    {
        return view('send');
    }

    public function send(): JsonResponse
    {
        $cabinets = Cabinet::get();
        $cabinet = Cabinet::findOrFail(1);
        $user = User::findOrFail(1);
        $users = User::role(['superAdmin', 'admin'])->get();
        $items = [
            'cabinets' => $cabinets,
            'cabinet' => $cabinet
        ];
        $user->notify(new RealTimeNotification($user->name));
        Notification::send($users, new RealTimeNotification('Привет пользователи'));
        return response()->json($items);
    }
}
