<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('dashboard', ["users" => $users]);
    }

    public function about()
    {
        return view('appointments');
    }   

    public function show($id)
    {
        $user = User::findOrFail($id);    
        return view('appointment-details', ["user" => $user]);
    }
}
