<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskUserAssignment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'task_id',
        'subtask_id', 
        'employee_position_id',
        'type'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function subtask()
    {
        return $this->belongsTo(Subtask::class);
    }

    public function employeePosition()
    {
        return $this->belongsTo(EmployeePosition::class);
    }
    
    /**
     * Get assigned users for a task
     */
    public static function getAssignedUsersForTask($taskId)
    {
        return self::where('task_id', $taskId)
                   ->where('type', 'task')
                   ->with('employeePosition.user')
                   ->get();
    }
    
    /**
     * Get assigned users for a subtask
     */
    public static function getAssignedUsersForSubtask($subtaskId)
    {
        return self::where('subtask_id', $subtaskId)
                   ->where('type', 'subtask')
                   ->with('employeePosition.user')
                   ->get();
    }
}
