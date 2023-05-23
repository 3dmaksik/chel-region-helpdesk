<?php

namespace App\Notifications;

use App\Base\Models\Model;
use App\Base\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ExpireNotification extends BaseNotification
{
    public Model $model;

    public string $method;

    public string $text;

    public int $count;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($method, $text, $count)
    {
        $this->method = $method;
        $this->text = $text;
        $this->count = $count;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
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
