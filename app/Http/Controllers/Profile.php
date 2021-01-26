<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class Profile extends Controller
{
    public function index()
    {
        $data = [
            "title" => "profile",
        ];

        return Inertia::render('Profile/Index', $data);
    }
}
