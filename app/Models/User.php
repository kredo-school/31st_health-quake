<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    /**
     * 外部から直接代入可能なカラム名を指定します。
     * これらのカラムは、モデルの `create()` や `update()` で使用できます。
     */
    protected $fillable = [
        'username',              // ユーザー名
        'password',              // パスワード（ハッシュ）
        'profile_photo_url',     // プロフィール画像URL ← 追加された項目
        'last_login_at',         // 最終ログイン日時
        'consecutive_days',      // 連続ログイン日数
        'level',                 // ユーザーレベル
    ];

    /**
     * APIやJSON出力時に非表示にするカラム名
     */
    protected $hidden = [
        'password',
    ];

    /**
     * ログイン状態を更新するメソッドです。
     */
    public function updateLoginStatus()
    {
        $today = now()->toDateString();
        $lastLoginDate = optional($this->last_login_at)->toDateString();

        if ($lastLoginDate === $today) {
            Log::info("[$this->username] Same day login detected. Skipping consecutive days update.");
            return;
        }

        if ($lastLoginDate && Carbon::parse($lastLoginDate)->addDay()->isSameDay($today)) {
            $this->increment('consecutive_days');
            Log::info("[$this->username] Incremented consecutive days. New count: " . ($this->consecutive_days + 1));
        } else {
            $this->consecutive_days = 1;
            Log::info("[$this->username] Consecutive login streak reset. New count: 1");
        }

        $this->last_login_at = now();
        Log::info("[$this->username] Updated last login time: " . $this->last_login_at);

        if ($lastLoginDate && Carbon::parse($lastLoginDate)->diffInDays(now()) >= 5) {
            $this->decrement('level');
            Log::info("[$this->username] Decreased level due to inactivity. New level: " . ($this->level - 1));
        }

        $this->save();
        Log::info("[$this->username] Saved user data successfully.");
    }

    public function habits(): HasMany
    {
        return $this->hasMany(Habit::class);
    }

    public function routines(): HasMany
    {
        return $this->hasMany(Routine::class);
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'user_tasks')
            ->withPivot(['order', 'points', 'scheduled_time', 'is_completed', 'last_completed_at', 'consecutive_days', 'completion_count'])
            ->withTimestamps();
    }

    public function userLevel(): HasOne
    {
        return $this->hasOne(UserLevel::class);
    }

    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

    public function userTasks(): HasMany
    {
        return $this->hasMany(UserTask::class);
    }

    public function todaysTasks()
    {
        return $this->userTasks()
            ->whereDate('updated_at', now()->toDateString());
    }
}
