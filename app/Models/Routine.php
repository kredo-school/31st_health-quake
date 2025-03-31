<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Routine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'is_active',
        'start_time',
        'type',
        'estimated_duration',
    ];

    /**
     * キャストする属性
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * このルーティンを所有するユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このルーティンに含まれるタスクを取得
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'user_tasks')
            ->withPivot(['order', 'points', 'scheduled_time', 'is_completed', 'last_completed_at'])
            ->orderBy('user_tasks.order')
            ->withTimestamps();
    }
}
