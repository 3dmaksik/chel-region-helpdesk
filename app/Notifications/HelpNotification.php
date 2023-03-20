<?php

namespace App\Notifications;

use App\Base\Models\Model;
use App\Base\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class HelpNotification extends BaseNotification
{
    public Model $model;
    public string $method;
    public string $route;



    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($method, $route)
    {
        $this->method = $method;
        $this->route = $route;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
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
}
