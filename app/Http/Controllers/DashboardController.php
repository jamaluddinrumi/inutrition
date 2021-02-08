<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = \App\Models\Customer::with('nutrition')->get();
        $users = \App\Models\User::get();;

        $data = [
            "title" => "dashboard",
            "customers" => $customers,
            "users" => $users,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
        ];
        return Inertia::render("Dashboard", $data);
    }
}
