<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarbersApprovalController extends Controller
{
    public function index(): View
    {
        $pendingBarbers = User::query()
            ->where('role', 'barber')
            ->where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedBarbers = User::query()
            ->where('role', 'barber')
            ->where('is_approved', true)
            ->orderBy('name')
            ->get();

        return view('admin.barbers-approval', [
            'pendingBarbers' => $pendingBarbers,
            'approvedBarbers' => $approvedBarbers,
        ]);
    }

    public function approve(Request $request, User $barber): RedirectResponse
    {
        if ($barber->role !== 'barber') {
            return back()->with('error', 'User is not a barber.');
        }

        $barber->update(['is_approved' => true]);

        return back()->with('status', "Barber '{$barber->name}' has been approved.");
    }

    public function reject(Request $request, User $barber): RedirectResponse
    {
        if ($barber->role !== 'barber') {
            return back()->with('error', 'User is not a barber.');
        }

        $barber->delete();

        return back()->with('status', "Barber application '{$barber->name}' has been rejected and deleted.");
    }
}
