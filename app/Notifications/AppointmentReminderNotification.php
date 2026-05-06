<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Upcoming appointment reminder',
            'message' => sprintf(
                'You have %s on %s at %s.',
                $this->appointment->service?->name ?? 'an appointment',
                $this->appointment->scheduled_at?->format('M d, Y'),
                $this->appointment->scheduled_at?->format('g:i A') ?? 'soon'
            ),
            'appointment_id' => $this->appointment->id,
        ];
    }
}
