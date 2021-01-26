<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'title' => $this->faker->title(),
            'city' => $this->faker->city(),
            'postcode' => $this->faker->postcode(),
            'street_address' => $this->faker->streetAddress(),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'email' => $this->faker->unique()->email,
        ];
    }
}
