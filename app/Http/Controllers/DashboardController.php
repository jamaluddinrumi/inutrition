<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $latestNutritions = \App\Models\Nutrition::take(10)->with('customer')->orderBy('updated_at')->get();
        // dump($latestNutritions);
        $latestCalories['value'] = [];
        $latestCalories['labels'] = [];

        foreach ($latestNutritions as $value) {
            array_push($latestCalories['value'], $value->calories);
            array_push($latestCalories['labels'], "{$value->customer->first_name} ({$value->calories})");
        }

        $customers = \App\Models\Customer::with('nutrition')->get();
        $users = \App\Models\User::get();;

        $data = [
            "title" => "dashboard",
            "customers" => $customers,
            "users" => $users,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'latestCalories' => $latestCalories,
        ];
        return Inertia::render("Dashboard", $data);
    }
}
