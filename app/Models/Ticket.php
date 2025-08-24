<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'user_id', 'from_id', 'to_id', 'todo_id', 'note', 
        'due_time', 'task_id', 'start_date', 'status'
    ];

    public function ticketTransitions()
    {
        return $this->hasMany(TicketTransition::class);
    }

    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employeePosition()
    {
        return $this->belongsTo(EmployeePosition::class, 'to_id');
    }

    public function fromEmployeePosition()
    {
        return $this->belongsTo(EmployeePosition::class, 'from_id');
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
}
