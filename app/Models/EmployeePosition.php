<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePosition extends Model
{
    use HasFactory;
    //protected $fillable = ['id', 'percentage', 'name', 'parent_id'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function childRelations() {
        return $this->hasMany(EmployeePositionRelation::class, 'parent_id');
    }
    

    public function children() {
        return $this->hasMany(EmployeePosition::class, 'parent_id');
    }
    

    public function subtasks()
{
    return $this->hasMany(Subtask::class, 'user_id', 'user_id');
}

    public function parent() {
        return $this->belongsTo(EmployeePosition::class, 'parent_id');
    }
}
