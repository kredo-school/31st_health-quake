<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'date', 'user_id']; // 全ての必要フィールドを指定

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}