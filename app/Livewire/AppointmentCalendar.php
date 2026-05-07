<?php

namespace App\Livewire;

use App\Models\Appointment;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AppointmentCalendar extends LivewireCalendar
{
    public function events(): Collection
    {
        $user = Auth::user();

        if (! $user) {
            return collect();
        }

        $query = Appointment::query()
            ->with(['service', 'barber', 'customer'])
            ->where('status', 'confirmed')
            ->whereBetween('scheduled_at', [$this->gridStartsAt, $this->gridEndsAt])
            ->orderBy('scheduled_at');

        if ($user->isBarber()) {
            $query->where('barber_id', $user->id);
        } else {
            $query->where('user_id', $user->id);
        }

        return $query->get()->map(function (Appointment $appointment) use ($user) {
            return [
                'id' => $appointment->id,
                'title' => $user->isBarber() ? $appointment->customer?->name : $appointment->service?->name,
                'description' => $user->isBarber()
                    ? ($appointment->service?->name ?? __('Service')) . ' · ' . $appointment->scheduled_at->format('g:i A')
                    : ($appointment->barber?->name ? __('Barber: ') . $appointment->barber->name : __('Barber: To be assigned')) . ' · ' . $appointment->scheduled_at->format('g:i A'),
                'date' => $appointment->scheduled_at,
            ];
        });
    }
}
