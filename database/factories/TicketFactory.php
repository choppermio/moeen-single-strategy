<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\EmployeePosition;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'user_id' => EmployeePosition::factory(),
            'from_id' => EmployeePosition::factory(),
            'to_id' => EmployeePosition::factory(),
            'todo_id' => 0,
            'note' => $this->faker->paragraph,
            'due_time' => $this->faker->dateTimeBetween('now', '+1 month'),
            'task_id' => Task::factory(),
            'start_date' => now(),
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
