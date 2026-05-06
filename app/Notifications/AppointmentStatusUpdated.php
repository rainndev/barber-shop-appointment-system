<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class AppointmentStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        protected Appointment $appointment,
        protected string $message
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'title' => 'Appointment status updated',
            'message' => $this->message,
            'appointment_id' => $this->appointment->id,
            'status' => $this->appointment->status,
        ]);
    }
}