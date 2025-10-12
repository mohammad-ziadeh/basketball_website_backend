<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UnpaidPaymentNotification extends Notification
{
    use Queueable;

    public $parent;
    public $course;
    public $amount;
    public $due_date;

    /**
     * Create a new notification instance.
     */
    public function __construct($parent, $course, $amount, $due_date)
    {
        $this->parent = $parent;
        $this->course = $course;
        $this->amount = $amount;
        $this->due_date = $due_date;
    }

    /**
     * Define the delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Store the notification in the database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pending Course Payment Reminder',
            'message' => "You still have an unpaid fee of {$this->amount} JOD for the course '{$this->course->name}'. Please complete the payment before {$this->due_date}.",
            'course_id' => $this->course->id,
            'amount' => $this->amount,
            'due_date' => $this->due_date,
            'parent_id' => $this->parent->id,
        ];
    }
}
