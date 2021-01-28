<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

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
        ];
        return Inertia::render("Dashboard", $data);
    }
}
