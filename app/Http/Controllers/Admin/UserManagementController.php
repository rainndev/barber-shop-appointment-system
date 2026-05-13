<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->orderBy('role', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.users.index', [
            'users' => $users,
            'totalUsers' => $users->count(),
            'adminUsers' => $users->where('role', 'admin')->count(),
            'barberUsers' => $users->where('role', 'barber')->count(),
            'customerUsers' => $users->where('role', 'customer')->count(),
            'approvedBarbers' => $users->where('role', 'barber')->where('is_approved', true)->count(),
            'pendingBarbers' => $users->where('role', 'barber')->where('is_approved', false)->count(),
        ]);
    }
}