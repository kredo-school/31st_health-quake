<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTask extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'task_id',
        'routine_id',
        'order',
        'points',
        'scheduled_time',
        'is_completed',
        'last_completed_at',
        'consecutive_days',
        'completion_count',
    ];

    /**
     * キャストする属性
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_time' => 'datetime',
        'last_completed_at' => 'datetime',
        'is_completed' => 'boolean',
    ];

    /**
     * このレコードを所有するユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このレコードに関連するタスクを取得
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * このレコードに関連するルーティンを取得
     */
    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class);
    }
}
