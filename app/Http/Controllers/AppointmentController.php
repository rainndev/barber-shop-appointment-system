<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AvailabilityBlock;
use App\Models\Service;
use App\Models\User;
use App\Models\WaitingListEntry;
use App\Notifications\WaitlistSlotOpened;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $serviceId = (int) $request->query('service_id', 0);
        $barberId = (int) $request->query('barber_id', 0);
        $selectedDate = $request->query('date', now()->toDateString());

        $services = Service::query()->where('is_active', true)->orderBy('name')->get();
        $barbers = User::query()->where('role', 'barber')->orderBy('name')->get();
        $selectedService = $serviceId
            ? $services->firstWhere('id', $serviceId) ?? $services->first()
            : $services->first();
        $selectedBarber = $barberId
            ? $barbers->firstWhere('id', $barberId)
            : null;

        return view('appointments', [
            'appointments' => $this->appointmentsFor($user),
            'services' => $services,
            'selectedService' => $selectedService,
            'selectedBarber' => $selectedBarber,
            'selectedDate' => $selectedDate,
            'availableSlots' => $selectedService
                ? $this->buildAvailableSlots($selectedService, Carbon::parse($selectedDate), $selectedBarber?->id)
                : [],
            'waitlistEntries' => WaitingListEntry::query()
                ->with('service')
                ->where('user_id', $user->id)
                ->latest()
                ->get(),
            'barbers' => $barbers,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'scheduled_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'barber_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'barber')),
            ],
        ]);

        $service = Service::query()->findOrFail($data['service_id']);
        $scheduledAt = Carbon::parse($data['scheduled_at']);
        $barber = $this->availableBarberForSlot(
            $scheduledAt,
            $service->duration_minutes,
            $data['barber_id'] ?? null
        );

        if (! $barber) {
            WaitingListEntry::query()->create([
                'user_id' => $request->user()->id,
                'service_id' => $service->id,
                'preferred_date' => $scheduledAt->toDateString(),
                'preferred_time' => $scheduledAt->format('H:i:s'),
                'notes' => $data['notes'] ?? null,
                'status' => 'waiting',
            ]);

            return back()->with('status', 'That slot is full. You were added to the waiting list.');
        }

        Appointment::query()->create([
            'user_id' => $request->user()->id,
            'barber_id' => $barber->id,
            'service_id' => $service->id,
            'scheduled_at' => $scheduledAt,
            'ends_at' => $scheduledAt->copy()->addMinutes($service->duration_minutes),
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);

        return back()->with('status', 'Appointment requested successfully. Waiting for barber acceptance.');
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $this->authorizeAppointment($request, $appointment);

        if (! $this->canModify($appointment)) {
            return back()->with('status', 'Appointments can only be changed at least 24 hours before the booking.');
        }

        $data = $request->validate([
            'scheduled_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $scheduledAt = Carbon::parse($data['scheduled_at']);

        if (! $this->barberAvailableForSlot($appointment->barber_id, $scheduledAt, $appointment->service->duration_minutes, $appointment->id)) {
            return back()->with('status', 'The selected slot is no longer available.');
        }

        $appointment->update([
            'scheduled_at' => $scheduledAt,
            'ends_at' => $scheduledAt->copy()->addMinutes($appointment->service->duration_minutes),
            'notes' => $data['notes'] ?? $appointment->notes,
        ]);

        return back()->with('status', 'Appointment updated successfully.');
    }

    public function destroy(Request $request, Appointment $appointment): RedirectResponse
    {
        $this->authorizeAppointment($request, $appointment);

        if (! $this->canModify($appointment)) {
            return back()->with('status', 'Appointments can only be cancelled at least 24 hours before the booking.');
        }

        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => 'Cancelled by user',
        ]);

        $this->promoteWaitlist($appointment);

        return back()->with('status', 'Appointment cancelled successfully.');
    }

    public function show(Request $request, Appointment $appointment): View
    {
        $this->authorizeAppointment($request, $appointment);

        $appointment->load(['customer', 'service', 'barber']);

        return view('appointment-details', [
            'appointment' => $appointment,
            'calendarUrl' => $this->googleCalendarUrl($appointment),
        ]);
    }

    public function accept(Request $request, Appointment $appointment): RedirectResponse
    {
        $this->authorizeBarber($request, $appointment);

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Only pending appointments can be accepted.');
        }

        $appointment->update(['status' => 'confirmed']);

        return back()->with('status', 'Appointment accepted successfully.');
    }

    public function decline(Request $request, Appointment $appointment): RedirectResponse
    {
        $this->authorizeBarber($request, $appointment);

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Only pending appointments can be declined.');
        }

        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => 'Declined by barber',
        ]);

        $this->promoteWaitlist($appointment);

        return back()->with('status', 'Appointment declined successfully.');
    }

    public function ics(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($request, $appointment);

        $appointment->load('service', 'barber');

        $summary = $appointment->service->name . ' appointment';
        $description = trim(implode("\n", array_filter([
            'Barber: ' . ($appointment->barber?->name ?? 'To be assigned'),
            'Notes: ' . ($appointment->notes ?: 'None'),
        ])));

        $ics = implode("\r\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Barber Shop Appointment System//EN',
            'BEGIN:VEVENT',
            'UID:appointment-' . $appointment->id . '@barbershop',
            'DTSTAMP:' . now()->utc()->format('Ymd\THis\Z'),
            'DTSTART:' . $appointment->scheduled_at->utc()->format('Ymd\THis\Z'),
            'DTEND:' . $appointment->ends_at->utc()->format('Ymd\THis\Z'),
            'SUMMARY:' . $summary,
            'DESCRIPTION:' . str_replace(["\r", "\n"], [' ', '\\n'], $description),
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="appointment-' . $appointment->id . '.ics"',
        ]);
    }

    private function appointmentsFor(User $user)
    {
        return match ($user->role) {
            'admin' => Appointment::query()->with(['customer', 'barber', 'service'])->latest('scheduled_at')->get(),
            'barber' => Appointment::query()->with(['customer', 'service'])->where('barber_id', $user->id)->latest('scheduled_at')->get(),
            default => Appointment::query()->with(['barber', 'service'])->where('user_id', $user->id)->latest('scheduled_at')->get(),
        };
    }

    private function buildAvailableSlots(Service $service, Carbon $date, ?int $preferredBarberId = null): array
    {
        $openingHours = $this->openingHoursFor($date);

        if ($openingHours === null) {
            return [];
        }

        [$startTime, $endTime] = $openingHours;
        $slots = [];
        $cursor = Carbon::parse($date->toDateString() . ' ' . $startTime);
        $closing = Carbon::parse($date->toDateString() . ' ' . $endTime);

        while ($cursor->copy()->addMinutes($service->duration_minutes)->lte($closing)) {
            if ($this->availableBarberForSlot($cursor, $service->duration_minutes, $preferredBarberId)) {
                $slots[] = $cursor->format('Y-m-d\TH:i');
            }

            $cursor->addMinutes((int) config('barbershop.slot_interval_minutes', 30));
        }

        return $slots;
    }

    private function openingHoursFor(Carbon $date): ?array
    {
        $openingHours = config('barbershop.opening_hours', []);
        $dayKey = strtolower($date->format('l'));

        return $openingHours[$dayKey] ?? null;
    }

    private function availableBarberForSlot(Carbon $scheduledAt, int $durationMinutes, ?int $preferredBarberId = null, ?int $ignoreAppointmentId = null): ?User
    {
        $barbers = User::query()
            ->where('role', 'barber')
            ->when($preferredBarberId, fn ($query) => $query->where('id', $preferredBarberId))
            ->orderBy('name')
            ->get();

        foreach ($barbers as $barber) {
            if ($this->barberAvailableForSlot($barber->id, $scheduledAt, $durationMinutes, $ignoreAppointmentId)) {
                return $barber;
            }
        }

        return null;
    }

    private function barberAvailableForSlot(int $barberId, Carbon $scheduledAt, int $durationMinutes, ?int $ignoreAppointmentId = null): bool
    {
        $endsAt = $scheduledAt->copy()->addMinutes($durationMinutes);

        if (! $this->withinOperatingHours($scheduledAt, $durationMinutes)) {
            return false;
        }

        $blocked = AvailabilityBlock::query()
            ->where(function ($query) use ($barberId) {
                $query->whereNull('barber_id')->orWhere('barber_id', $barberId);
            })
            ->where('starts_at', '<', $endsAt)
            ->where('ends_at', '>', $scheduledAt)
            ->exists();

        if ($blocked) {
            return false;
        }

        return ! Appointment::query()
            ->where('barber_id', $barberId)
            ->whereIn('status', ['confirmed', 'pending'])
            ->when($ignoreAppointmentId, fn ($query) => $query->where('id', '!=', $ignoreAppointmentId))
            ->where('scheduled_at', '<', $endsAt)
            ->where('ends_at', '>', $scheduledAt)
            ->exists();
    }

    private function withinOperatingHours(Carbon $scheduledAt, int $durationMinutes): bool
    {
        $openingHours = $this->openingHoursFor($scheduledAt);

        if ($openingHours === null) {
            return false;
        }

        [$startTime, $endTime] = $openingHours;
        $slotEnd = $scheduledAt->copy()->addMinutes($durationMinutes);
        $opening = Carbon::parse($scheduledAt->toDateString() . ' ' . $startTime);
        $closing = Carbon::parse($scheduledAt->toDateString() . ' ' . $endTime);

        return $scheduledAt->greaterThanOrEqualTo($opening) && $slotEnd->lessThanOrEqualTo($closing);
    }

    private function canModify(Appointment $appointment): bool
    {
        return now()->addHours((int) config('barbershop.cancellation_window_hours', 24))->lt($appointment->scheduled_at);
    }

    private function authorizeAppointment(Request $request, Appointment $appointment): void
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return;
        }

        if ($user->isBarber() && (int) $appointment->barber_id === (int) $user->id) {
            return;
        }

        abort_unless((int) $appointment->user_id === (int) $user->id, 403);
    }

    private function authorizeBarber(Request $request, Appointment $appointment): void
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return;
        }

        abort_unless($user->isBarber() && (int) $appointment->barber_id === (int) $user->id, 403);
    }

    private function promoteWaitlist(Appointment $cancelledAppointment): void
    {
        $entry = WaitingListEntry::query()
            ->with(['user', 'service'])
            ->where('service_id', $cancelledAppointment->service_id)
            ->where('status', 'waiting')
            ->where(function ($query) use ($cancelledAppointment) {
                $query->whereNull('preferred_date')
                    ->orWhereDate('preferred_date', $cancelledAppointment->scheduled_at->toDateString());
            })
            ->where(function ($query) use ($cancelledAppointment) {
                $query->whereNull('preferred_time')
                    ->orWhere('preferred_time', $cancelledAppointment->scheduled_at->format('H:i:s'));
            })
            ->orderBy('created_at')
            ->first();

        if (! $entry) {
            return;
        }

        $newAppointment = Appointment::query()->create([
            'user_id' => $entry->user_id,
            'barber_id' => $cancelledAppointment->barber_id,
            'service_id' => $entry->service_id,
            'scheduled_at' => $cancelledAppointment->scheduled_at,
            'ends_at' => $cancelledAppointment->ends_at,
            'status' => 'confirmed',
            'notes' => $entry->notes,
        ]);

        $entry->update([
            'status' => 'promoted',
            'appointment_id' => $newAppointment->id,
            'notified_at' => now(),
        ]);

        $entry->user->notify(new WaitlistSlotOpened($entry, $newAppointment));
    }

    private function googleCalendarUrl(Appointment $appointment): string
    {
        $base = 'https://calendar.google.com/calendar/render?action=TEMPLATE';

        return $base . '&text=' . urlencode($appointment->service->name . ' appointment')
            . '&dates=' . $appointment->scheduled_at->utc()->format('Ymd\THis\Z') . '/' . $appointment->ends_at->utc()->format('Ymd\THis\Z')
            . '&details=' . urlencode($appointment->notes ?? 'Barber shop appointment');
    }
}
