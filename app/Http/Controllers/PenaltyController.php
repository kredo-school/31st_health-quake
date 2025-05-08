<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // ユーザーモデルをインポート
use Carbon\Carbon; // Carbon をインポート

class PenaltyController extends Controller
{
    /**
     * ペナルティ画面を表示するアクション
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // 現在のユーザーを取得
        $user = Auth::user();

        // 前回ログイン日時を取得
        $lastLoginDate = $user->last_login_at;

        // 今日の日付を取得
        $today = now();

        // 連続してログインしなかった日数を計算
        $consecutiveDays = $today->diffInDays($lastLoginDate);

        // 負の値をゼロに調整
        $consecutiveDays = max(0, $consecutiveDays);

        // ユーザーの前のレベルを取得
        $previousLevel = $user->level;

        // レベルを下げるロジック（例：5日以上ログインしなかったらレベルを1下げる）
        if ($consecutiveDays >= 5) {
            $currentLevel = $previousLevel - 1;
            // データベースにレベルを更新（必要であれば）
            $user->update(['level' => $currentLevel]);
        } else {
            $currentLevel = $previousLevel;
        }

        // ペナルティ画面に必要なデータをビューに渡す
        return view('penalty', [
            'consecutiveDays' => $consecutiveDays,
            'previousLevel' => $previousLevel,
            'currentLevel' => $currentLevel,
        ]);
    }
}