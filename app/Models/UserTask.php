<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTask extends Model
{
    use HasFactory;

    /**
     * 一括代入可能な属性の定義
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
     * 型変換の定義（キャスト）
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_time' => 'datetime',
        
    ];

    /**
     * 所有するユーザーを取得（リレーション）
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 紐づくタスクを取得（リレーション）
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * 紐づくルーティンを取得（リレーション）
     */
    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class);
    }
}
