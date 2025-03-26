<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class LoginRecordController extends Controller
{
    /**
     * ログイン後の連続ログイン記録ページを表示するメソッド
     */
    public function index(Request $request)
    {
        // 認証済みユーザーを取得
        $user = $request->user();

        // ログイン状態を更新
        $user->updateLoginStatus();

        // ボーナスメッセージの初期化
        $bonusMessage = null;
        if ($user->consecutive_days >= 3) {
            $bonusMessage = "Congratulations! You've earned a login bonus.";
        }

        // ペナルティーメッセージの初期化
        $penaltyMessage = null;
        if ($user->last_login_at && $user->last_login_at->diffInDays(now()) >= 5) {
            $penaltyMessage = "You missed logging in for 5 days. Your level has decreased.";
            $user->decrement('level'); // ペナルティーとしてレベルを下げる
            $user->save();
        }

        // ビューを返す
        return view('login_record', compact('user', 'bonusMessage', 'penaltyMessage'));
    }
}