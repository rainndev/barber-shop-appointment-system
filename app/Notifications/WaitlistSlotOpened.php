<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Models\WaitingListEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WaitlistSlotOpened extends Notification
{
    use Queueable;

    public function __construct(
        public WaitingListEntry $entry,
        public Appointment $appointment,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Appointment slot opened',
            'message' => sprintf(
                'Your waiting list request for %s is now confirmed for %s.',
                $this->entry->service?->name ?? 'your service',
                $this->appointment->scheduled_at?->format('M d, Y g:i A') ?? 'the selected slot'
            ),
            'appointment_id' => $this->appointment->id,
            'waiting_list_entry_id' => $this->entry->id,
        ];
    }
}
