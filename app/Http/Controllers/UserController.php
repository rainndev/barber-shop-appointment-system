<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
       ]);

        $user = User::create($validatedData);
        if ($user) {
            return redirect()->back()->with('success', 'Registration successful!');
        } else {
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'loginname' => 'required|string|max:255',
            'loginpassword' => 'required|min:6',
       ]);

        if (Auth::guard()->attempt([
            'name' => $validatedData['loginname'],
            'password' => $validatedData['loginpassword']
        ])) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Login failed. Please check your credentials and try again.');
        }
    }

    public function logout()
    {
        Auth::guard()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
