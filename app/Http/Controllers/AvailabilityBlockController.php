<?php

namespace App\Http\Controllers;

use App\Models\AvailabilityBlock;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AvailabilityBlockController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'barber_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'barber')),
            ],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        AvailabilityBlock::query()->create([
            'barber_id' => $data['barber_id'] ?? null,
            'blocked_by_id' => $request->user()->id,
            'starts_at' => Carbon::parse($data['starts_at']),
            'ends_at' => Carbon::parse($data['ends_at']),
            'reason' => $data['reason'] ?? null,
        ]);

        return back()->with('status', 'Availability block saved successfully.');
    }

    public function destroy(AvailabilityBlock $availabilityBlock): RedirectResponse
    {
        AvailabilityBlock::query()->whereKey($availabilityBlock->getKey())->delete();

        return back()->with('status', 'Availability block removed successfully.');
    }
}
