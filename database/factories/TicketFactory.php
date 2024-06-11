<?php

namespace Database\Factories;

use App\Models\TicketCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => 'https://img.freepik.com/free-photo/two-tickets-blue-front-view-isolated-white_1101-3055.jpg?t=st=1716109393~exp=1716112993~hmac=b0a3fbb91c6aa81e48b7c993a2f7bf319b4f777318c659813974ca7cd7a419ba&w=1800',
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(50000, 100000),
            'quota' => $this->faker->numberBetween(500, 1000),
            'ticket_category_id' => TicketCategory::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['Tersedia', 'Tidak Tersedia']),
            'type' => $this->faker->randomElement(['Domestik', 'Mancanegara']),
            'is_featured' => $this->faker->boolean(),
        ];
    }
}
