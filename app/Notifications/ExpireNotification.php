<?php

namespace App\Notifications;

use App\Base\Models\Model;
use App\Base\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ExpireNotification extends BaseNotification
{
    public Model $model;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public string $method, public string $text, public int $count)
    {
    }

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
            'text' => $this->text,
            'count' => $this->count,
        ]);
    }
}
