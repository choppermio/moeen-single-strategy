<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'route',
        'group'
    ];

    /**
     * The employee positions that have this permission
     */
    public function employeePositions()
    {
        return $this->belongsToMany(EmployeePosition::class, 'employee_position_permission');
    }
}
