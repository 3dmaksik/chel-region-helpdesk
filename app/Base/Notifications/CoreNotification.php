<?php

namespace App\Base\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;

abstract class CoreNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
}
