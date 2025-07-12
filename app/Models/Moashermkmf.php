<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moashermkmf extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'percentage', 'name', 'parent_id','type'];

    public function todos()
  {
    return $this->belongsToMany(Todo::class);
  }

  public function tasks()
  {
      return $this->belongsToMany(Task::class);
  }
}
