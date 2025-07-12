<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Subtask extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = ['id', 'percentage', 'name', 'parent_id','done','user_id','status','parent_user_id','finished_user_id','transfered','notes','due_time'];
    
    public function userAssignments()
    {
        return $this->hasMany(TaskUserAssignment::class);
    }
    
    public function assignedEmployees()
    {
        return $this->hasMany(TaskUserAssignment::class)->with('employeePosition.user');
    }
}
