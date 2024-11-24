<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::all()->random()->id,
            'sort' => fake()->numberBetween(1, 10),
            'product_name' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 20),
            'price' => fake()->randomFloat(2, 1, 100),
        ];
    }
}
