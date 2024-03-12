<?php

namespace App\Base\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;

class BaseNotification extends CoreNotification
{
	use Queueable;
}
