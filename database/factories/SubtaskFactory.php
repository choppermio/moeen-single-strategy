<?php

namespace Database\Factories;

use App\Models\Subtask;
use App\Models\EmployeePosition;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubtaskFactory extends Factory
{
    protected $model = Subtask::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'percentage' => 0,
            'parent_id' => Task::factory(),
            'done' => 0,
            'user_id' => EmployeePosition::factory(),
            'parent_user_id' => EmployeePosition::factory(),
            'due_time' => $this->faker->dateTimeBetween('now', '+1 month'),
            'start_date' => now(),
            'ticket_id' => null,
            'notes' => $this->faker->paragraph,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
