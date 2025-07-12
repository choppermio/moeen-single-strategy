<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadafstrategy extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'percentage', 'name', 'parent_id','user_id'];

}
