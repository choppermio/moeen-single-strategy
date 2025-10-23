<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    //fillable
    protected $fillable = [
    'id', 'percentage', 'name', 'parent_id','user_id','output','hidden',
    'user', 
    'marketing_cost',
    'real_cost',
    'sp_week',
    'ep_week',
    'sr_week',
    'er_week',
    'r_money_paid',
    'marketing_verified',
    'complete_percentage',
    'quality_percentage',
    'evidence',
    'roi',
    'customers_count',
    'perf_note',
    'recomm',
    'notes'];
    public function moashermkmfs()
    {
        return $this->belongsToMany(Moashermkmf::class);
    }
    
    public function userAssignments()
    {
        return $this->hasMany(TaskUserAssignment::class);
    }
    
    public function assignedEmployees()
    {
        return $this->hasMany(TaskUserAssignment::class)->with('employeePosition.user');
    }
    
}
