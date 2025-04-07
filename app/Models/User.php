<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Reward;
use App\Models\UserTask; // UserTaskモデルもインポート（必要な場合）

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * ユーザーのルーティンを取得
     */
    public function routines(): HasMany
    {
        return $this->hasMany(Routine::class);
    }

    /**
     * ユーザーのタスクを取得
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'user_tasks')
            ->withPivot(['order', 'points', 'scheduled_time', 'is_completed', 'last_completed_at', 'consecutive_days', 'completion_count'])
            ->withTimestamps();
    }

    /**
     * ユーザーのレベル情報を取得
     */
    public function userLevel(): HasOne
    {
        return $this->hasOne(UserLevel::class);
    }

    /**
     * ユーザーのカレンダー記録を取得
     */
    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

    /**
     * ユーザーのタスク進捗状況を取得
     */
    public function userTasks(): HasMany
    {
        return $this->hasMany(UserTask::class);
    }

    /**
     * ユーザーの今日のタスク進捗状況を取得
     */
    public function todaysTasks()
    {
        return $this->userTasks()
            ->whereDate('updated_at', now()->toDateString());
    }
    /**
 * ユーザーが持つ報酬を取得
 */
public function rewards()
{
    return $this->hasMany(Reward::class);
}
/**
 * ユーザーの習慣を取得
 */
public function habits(): HasMany
{
    return $this->hasMany(Habit::class);
}

}
