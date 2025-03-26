<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    //// 許可される属性を指定
    protected $fillable = ['name', 'category', 'date'];
}
