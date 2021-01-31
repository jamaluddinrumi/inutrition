<?php

namespace App\Http\Controllers;

use App\Models\Nutrition;
use Inertia\Inertia;

class NutritionController extends Controller
{
    public function index()
    {
        $nutritions = Nutrition::all();

        $data = [
            'nutritions' => $nutritions,
            'title' => 'nutrition'
        ];
        return Inertia::render('Nutrition', $data);
    }
}
