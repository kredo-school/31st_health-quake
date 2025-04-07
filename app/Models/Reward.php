<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'level',
        'image',
        'user_id'
    ];

    /**
     * この報酬を所有するユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
