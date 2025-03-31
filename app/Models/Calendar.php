<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'record_date',
        'completed_tasks',
        'total_tasks',
        'points_earned',
        'notes',
        'mood_rating',
        'completed_task_ids',
    ];

    /**
     * キャストする属性
     *
     * @var array<string, string>
     */
    protected $casts = [
        'record_date' => 'date',
        'completed_task_ids' => 'json',
    ];

    /**
     * このカレンダー記録を所有するユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 完了率を計算
     */
    public function getCompletionRateAttribute(): float
    {
        if ($this->total_tasks === 0) {
            return 0;
        }

        return round(($this->completed_tasks / $this->total_tasks) * 100, 1);
    }

    /**
     * 完了したタスクオブジェクトの配列を取得
     */
    public function getCompletedTasksAttribute(): array
    {
        if (!$this->completed_task_ids) {
            return [];
        }

        return Task::whereIn('id', $this->completed_task_ids)->get()->toArray();
    }
}
