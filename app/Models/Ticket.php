<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

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
}
