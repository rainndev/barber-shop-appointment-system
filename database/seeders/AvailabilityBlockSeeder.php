<?php

namespace Database\Seeders;

use App\Models\AvailabilityBlock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AvailabilityBlockSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('role', 'admin')->first();
        $barber = User::query()->where('role', 'barber')->first();

        if (! $admin) {
            return;
        }

        $startsAt = Carbon::now()->addDays(1)->setTime(12, 0);
        $endsAt = $startsAt->copy()->addHour();

        AvailabilityBlock::query()->updateOrCreate(
            [
                'barber_id' => $barber?->id,
                'starts_at' => $startsAt,
            ],
            [
                'blocked_by_id' => $admin->id,
                'ends_at' => $endsAt,
                'reason' => 'Lunch break',
            ]
        );
    }
}
