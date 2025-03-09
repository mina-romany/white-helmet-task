<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->sentence,
            'status' => 'in:PENDING,INPROGRESS,COMPLETED',
            'assignee_id' => \App\Models\User::factory(),
            'due_date' => $this->faker->dateTimeBetween('now', '+01 days')
        ];
    }
}
