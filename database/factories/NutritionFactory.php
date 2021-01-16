<?php

namespace Database\Factories;

use App\Models\Nutrition;
use Illuminate\Database\Eloquent\Factories\Factory;

class NutritionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nutrition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => 1,
            'calories' => mt_rand(0, 100),
            'fat' => mt_rand(0, 100),
            'carbs' => mt_rand(0, 100),
            'protein' => mt_rand(0, 100)
        ];
    }
}
