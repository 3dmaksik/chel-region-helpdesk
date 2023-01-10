<?php

namespace App\Notifications;

use App\Base\Models\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class WorkHelpNotification extends Notification implements ShouldBroadcast
{
    public Model $model;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
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
            'helpId' => $this->model->id,
            'category' => $this->model->category->description,
            'cabinet' => $this->model->work->cabinet->description,
            'firstname' => $this->model->work->firstname,
            'lastname' => $this->model->work->lastname,
            'patronymic' => $this->model->work->patronymic,
            'calendarRequest' => date('d.m.Y H:i', strtotime($this->model->calendar_request)),
            'calendarExecution' => date('d.m.Y H:i', strtotime($this->model->calendar_execution)),
            'calendarFinal' => 'Дата неопределена',
            'status' => 'work',
        ]);
    }
}
