<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\WaitingListEntry;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $service = Service::query()->first();
        $barber = User::query()->where('role', 'barber')->first();
        $customer = User::query()->where('role', 'customer')->first();

        if (! $service || ! $barber || ! $customer) {
            return;
        }

        $scheduledAt = Carbon::now()->addDays(1)->setTime(10, 0);

        $appointment = Appointment::query()->updateOrCreate(
            [
                'user_id' => $customer->id,
                'barber_id' => $barber->id,
                'service_id' => $service->id,
                'scheduled_at' => $scheduledAt,
            ],
            [
                'ends_at' => $scheduledAt->copy()->addMinutes($service->duration_minutes),
                'status' => 'confirmed',
                'notes' => 'Prefers a low fade and clean neckline.',
            ]
        );

        $preferredDate = Carbon::now()->addDays(2)->toDateString();

        WaitingListEntry::query()->updateOrCreate(
            [
                'user_id' => $customer->id,
                'service_id' => $service->id,
                'preferred_date' => $preferredDate,
                'preferred_time' => '11:00:00',
            ],
            [
                'notes' => 'Flexible on the exact hour if a slot opens.',
                'status' => 'waiting',
            ]
        );
    }
}
