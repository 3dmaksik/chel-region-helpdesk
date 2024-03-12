<?php

namespace App\Base\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BaseNotification implements ShouldBroadcast
{
    use Queueable;
}
