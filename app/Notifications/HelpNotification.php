<?php

namespace App\Notifications;

use App\Base\Models\Model;
use App\Base\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class HelpNotification extends BaseNotification
{
    public Model $model;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public string $method, public string $route) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'method' => $this->method,
            'route' => $this->route,
        ]);
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'.$this->id;
    }
}
