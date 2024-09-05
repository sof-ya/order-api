<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrderType;
use App\Models\Partnership;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => OrderType::all()->random()->id,
            'partnership_id' => Partnership::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'description' => $this->faker->text(50),
            'date' => $this->faker->dateTimeBetween("-10 days", "+30 days"),
            'address' => $this->faker->address,
            'amount' => $this->faker->numberBetween(1000, 30000),
            'status' => $this->faker->randomElement(['Назначен исполнитель', 'Завершен']),
        ];
    }
}
