<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence, 
            'description' => $this->faker->paragraph,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'location' => $this->faker->city,
            'capacity' => $this->faker->numberBetween(10, 100),
            'status' => 'aberto',
        ];
    }
}
