<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 'password', 'last_login_at', 'consecutive_days', 'level'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * ログイン状態を更新するメソッド
     */
    public function updateLoginStatus()
    {
        $today = now()->toDateString();
        $lastLoginDate = optional($this->last_login_at)->toDateString();

        // 同じ日に再度ログインした場合はスキップ
        if ($lastLoginDate === $today) {
            return;
        }

        // 前回ログインから1日経過していれば連続ログイン日数を増やす
        if ($lastLoginDate && Carbon::parse($lastLoginDate)->addDay()->isSameDay($today)) {
            $this->increment('consecutive_days');
        } else {
            // 連続ログインが途切れた場合
            $this->consecutive_days = 1;
        }

        // 前回ログイン日時を更新
        $this->last_login_at = now();

        // 5日以上ログインしなかった場合、ペナルティーとしてレベルを下げる
        if ($lastLoginDate && Carbon::parse($lastLoginDate)->diffInDays(now()) >= 5) {
            $this->decrement('level');
        }

        // データベースに保存
        $this->save();
    }
}