<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moasheradastrategy extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'percentage', 'name', 'parent_id','user_id'];

    public function todos()
    {
      return $this->belongsToMany(Todo::class);
    }
    
    public function mobadaras()
    {
      return $this->belongsToMany(Mubadara::class);
    }
}
