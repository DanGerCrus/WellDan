<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'date_order' => $this->faker->date(),
            'status_id' => 1,
            'creator_id' => User::factory()->create()->id,
            'client_id' => User::factory()->create()->id,
        ];
    }
}
