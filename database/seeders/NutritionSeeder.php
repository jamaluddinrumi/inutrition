<?php

namespace Database\Seeders;

use App\Models\Nutrition;
use Illuminate\Database\Seeder;

class NutritionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nutrition::factory()
            ->count(15)
            ->create();
    }
}
