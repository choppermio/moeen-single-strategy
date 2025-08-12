<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\EmployeePosition;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'user_id' => EmployeePosition::factory(),
            'parent_id' => null,
            'percentage' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
