<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'scientific_evidence',
        'default_points',
        'category',
        'has_timer',
        'timer_duration',
        'benefits',
        'title', 'date',
    ];

    /**
     * Taskに関連するユーザーを取得
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_tasks')
            ->withPivot(['order', 'points', 'scheduled_time', 'is_completed', 'last_completed_at', 'consecutive_days', 'completion_count'])
            ->withTimestamps();
    }

    /**
     * Taskに関連するルーティンを取得
     */
    public function routines(): BelongsToMany
    {
        return $this->belongsToMany(Routine::class, 'user_tasks')
            ->withPivot(['order', 'points', 'scheduled_time', 'is_completed', 'last_completed_at'])
            ->withTimestamps();
    }
}
