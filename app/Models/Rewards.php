<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rewards extends Model
{
    use HasFactory;

    /**
     * 代入可能なカラム
     */
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
