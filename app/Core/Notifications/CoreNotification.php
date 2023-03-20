<?php

namespace App\Core\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;

abstract class CoreNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
}
