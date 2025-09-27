<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification
{
    use Queueable;

    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database']; // no mail, just DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Event Created',
            'message' => "Event {$this->event->name} has been created.",
            'event_id' => $this->event->id,
        ];
    }
}

