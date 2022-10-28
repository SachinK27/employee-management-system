<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'task' => $this->faker->text,
            'assigned_by' => $this->faker->name,
            'assigned_to' => $this->faker->name,
            'assign_date' => $this->faker->datetime,
            'deadline' => $this->faker->datetime,
            'status' => $this->faker->text,
            'notes' => $this->faker->text,
            'priority' => $this->faker->text,
        ];
    }
}
