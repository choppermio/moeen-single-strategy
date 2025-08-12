<?php

namespace Database\Factories;

use App\Models\EmployeePosition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeePositionFactory extends Factory
{
    protected $model = EmployeePosition::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->jobTitle,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
