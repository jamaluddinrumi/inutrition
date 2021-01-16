<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class Dashboard extends Controller
{
    public function index()
    {
        $customers = \App\Models\Customer::with('nutrition')->get();

        $data = [
            "title" => "Dashboard",
            "customers" => $customers,
        ];
        return Inertia::render("Dashboard", $data);
    }
}
