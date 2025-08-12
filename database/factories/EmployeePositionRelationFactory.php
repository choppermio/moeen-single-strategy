<?php

namespace Database\Factories;

use App\Models\EmployeePositionRelation;
use App\Models\EmployeePosition;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeePositionRelationFactory extends Factory
{
    protected $model = EmployeePositionRelation::class;

    public function definition()
    {
        return [
            'parent_id' => EmployeePosition::factory(),
            'child_id' => EmployeePosition::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
