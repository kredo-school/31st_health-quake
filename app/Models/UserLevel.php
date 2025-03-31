<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLevel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'level',
        'experience_points',
        'points_to_next_level',
        'total_points_earned',
        'badges',
        'last_login_date',
        'login_streak',
        'achievements',
    ];

    /**
     * キャストする属性
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_login_date' => 'date',
        'badges' => 'json',
        'achievements' => 'json',
    ];

    /**
     * このレベル情報を所有するユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * レベルアップが可能かチェック
     */
    public function canLevelUp(): bool
    {
        return $this->experience_points >= $this->points_to_next_level;
    }

    /**
     * レベルアップ処理を実行
     */
    public function levelUp(): void
    {
        if ($this->canLevelUp()) {
            $this->level += 1;
            $this->experience_points -= $this->points_to_next_level;
            $this->points_to_next_level = $this->calculateNextLevelPoints();
            $this->save();
        }
    }

    /**
     * 次のレベルに必要なポイントを計算
     */
    protected function calculateNextLevelPoints(): int
    {
        // レベルが上がるにつれて必要なポイントが増加
        return 100 + ($this->level * 20);
    }
}
