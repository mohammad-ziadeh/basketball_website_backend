<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ChildAbsentNotification extends Notification
{
    use Queueable;

    public $child;
    public $date;
    public $status;

    public function __construct($child, $date, $status)
    {
        $this->child = $child;
        $this->date = $date;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database']; // you can also add 'mail' if needed
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Your child attendance updated',
            'message' => "Your child {$this->child->name} was marked {$this->status} on {$this->date}.",
            'child_id' => $this->child->id,
            'date' => $this->date,
            'status' => $this->status,
        ];
    }
}
