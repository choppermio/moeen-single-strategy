<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mubadara extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'percentage', 'name', 'parent_id'];

    public function moasheradastrategies()
    {
        return $this->belongsToMany(Moasheradastrategy::class);
    }
}
