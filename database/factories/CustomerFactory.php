<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'citizenship_number' => $this->faker->unique()->numerify('##########'),
            'father_name' => $this->faker->name('male'),
            'grandfather_name' => $this->faker->name('male'),
            'phone' => $this->faker->phoneNumber(),
            'ward_no' => (string) $this->faker->numberBetween(1, 20),
            'municipality_type' => $this->faker->randomElement([
                Customer::MUNICIPALITY_METROPOLITAN,
                Customer::MUNICIPALITY_SUB_METROPOLITAN,
                Customer::MUNICIPALITY_MUNICIPALITY,
                Customer::MUNICIPALITY_RURAL,
            ]),
            'address' => $this->faker->address(),
            'customer_type' => $this->faker->randomElement([
                Customer::TYPE_BUYER,
                Customer::TYPE_SELLER,
                Customer::TYPE_WITNESS,
            ]),
            'email' => $this->faker->unique()->safeEmail(),
            'date_of_birth' => $this->faker->date(),
        ];
    }
}