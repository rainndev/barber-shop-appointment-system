<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\AppointmentReminderNotification;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';

    protected $description = 'Send reminder notifications for upcoming barber appointments.';

    public function handle(): int
    {
        $appointments = Appointment::query()
            ->with(['customer', 'service'])
            ->whereIn('status', ['confirmed', 'pending'])
            ->whereNull('reminder_sent_at')
            ->whereBetween('scheduled_at', [now(), now()->addDay()])
            ->get();

        foreach ($appointments as $appointment) {
            $appointment->customer->notify(new AppointmentReminderNotification($appointment));
            $appointment->update(['reminder_sent_at' => now()]);
        }

        $this->info('Sent reminders for ' . $appointments->count() . ' appointment(s).');

        return self::SUCCESS;
    }
}
