<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AvailabilityBlock;
use App\Models\Service;
use App\Models\User;
use App\Models\WaitingListEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        return match ($request->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'barber' => redirect()->route('barber.dashboard'),
            default => redirect()->route('customer.dashboard'),
        };
    }

    public function customer(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'upcomingAppointments' => Appointment::query()
                ->with(['service', 'barber'])
                ->where('user_id', $user->id)
                ->where('status', 'confirmed')
                ->where('scheduled_at', '>=', now())
                ->orderBy('scheduled_at')
                ->get(),
            'waitingListEntries' => WaitingListEntry::query()
                ->with('service')
                ->where('user_id', $user->id)
                ->latest()
                ->get(),
            'services' => Service::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function barber(Request $request): View
    {
        $user = $request->user();

        return view('barber.dashboard', [
            'services' => Service::query()
                ->where('barber_id', $user->id)
                ->latest()
                ->get(),
            'appointments' => Appointment::query()
                ->with(['customer', 'service'])
                ->where('barber_id', $user->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->orderBy('scheduled_at')
                ->get(),
            'blocks' => AvailabilityBlock::query()
                ->where(function ($query) use ($user) {
                    $query->whereNull('barber_id')->orWhere('barber_id', $user->id);
                })
                ->latest('starts_at')
                ->take(8)
                ->get(),
        ]);
    }

    public function admin(Request $request): View
    {
        $peakHour = Appointment::query()
            ->selectRaw('HOUR(scheduled_at) as hour, COUNT(*) as total', [])
            ->where('status', '!=', 'cancelled')
            ->groupBy('hour')
            ->orderByDesc('total')
            ->first();

        return view('admin.dashboard', [
            'totalBookings' => Appointment::query()->get()->count(),
            'cancelledBookings' => Appointment::query()->where('status', 'cancelled')->count(),
            'waitingListCount' => WaitingListEntry::query()->where('status', 'waiting')->count(),
            'activeServicesCount' => Service::query()->where('is_active', true)->count(),
            'peakHour' => $peakHour?->hour,
            'pendingBarbers' => User::query()->where('role', 'barber')->where('is_approved', false)->count(),
            'upcomingAppointments' => Appointment::query()
                ->with(['customer', 'barber', 'service'])
                ->where('scheduled_at', '>=', now())
                ->whereIn('status', ['confirmed', 'pending'])
                ->orderBy('scheduled_at')
                ->take(10)
                ->get(),
            'blocks' => AvailabilityBlock::query()
                ->with(['barber', 'blockedBy'])
                ->latest('starts_at')
                ->take(10)
                ->get(),
            'barbers' => User::query()->where('role', 'barber')->orderBy('name')->get(),
            'services' => Service::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
