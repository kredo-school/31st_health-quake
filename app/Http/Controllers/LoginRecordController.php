<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginRecordController extends Controller
{
    /**
     * ログイン後の画面を表示するメソッド
     */
    public function index(Request $request)
    {
        // ログインしているユーザーを取得
        $user = $request->user();

        // ログイン状態を更新
        $user->updateLoginStatus();

        // ボーナスメッセージの初期化
        $bonusMessage = null;
        if ($user->consecutive_days >= 3) {
            $bonusMessage = "おめでとうございます！3日以上連続ログインしました。";
        }

        // ペナルティーメッセージの初期化
        $penaltyMessage = null;
        if ($user->last_login_at && $user->last_login_at->diffInDays(now()) >= 5) {
            $penaltyMessage = "5日以上ログインしなかったため、レベルが下がりました。";
        }

        // ビュー（画面）を返す
        return view('login_record', compact('user', 'bonusMessage', 'penaltyMessage'));
    }
}

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Carbon\Carbon;

// class LoginRecordController extends Controller
// {
//     /**
//      * ログイン後の連続ログイン記録ページを表示するメソッド
//      */
//     public function index(Request $request)
//     {
//         // 認証済みユーザーを取得
//         $user = $request->user();

//         // ログイン状態を更新
//         $this->updateLoginStatus($user);

//         // ボーナスメッセージの初期化
//         $bonusMessage = null;
//         if ($user->consecutive_days >= 3) {
//             $bonusMessage = "Congratulations! You've earned a login bonus.";
//         }

//         // ペナルティーメッセージの初期化
//         $penaltyMessage = null;
//         if ($user->last_login_at && $user->last_login_at->diffInDays(now()) >= 5) {
//             $penaltyMessage = "You missed logging in for 5 days. Your level has decreased.";
//             $user->decrement('level'); // ペナルティーとしてレベルを下げる
//             $user->save();
//         }

//         // ビューを返す
//         return view('login_record', compact('user', 'bonusMessage', 'penaltyMessage'));
//     }

//     /**
//      * ユーザーのログイン状態を更新するメソッド
//      *
//      * @param \App\Models\User $user
//      */
//     protected function updateLoginStatus($user)
//     {
//         // 現在の日付を取得
//         $now = Carbon::now();

//         // 最終ログイン日時を確認
//         if ($user->last_login_at) {
//             // 前回ログイン日時と現在の日付の差を計算
//             $daysSinceLastLogin = $user->last_login_at->diffInDays($now);

//             // 前回ログインから1日以内の場合、連続ログイン日数を増やす
//             if ($daysSinceLastLogin === 1) {
//                 $user->increment('consecutive_days');
//             }
//             // 同じ日にログインした場合は連続ログイン日数を変更しない
//             elseif ($daysSinceLastLogin === 0) {
//                 // 何もしない
//             }
//             // それ以外の場合（2日以上空いた場合）、連続ログイン日数をリセット
//             else {
//                 $user->consecutive_days = 1;
//             }
//         } else {
//             // 初回ログインの場合、連続ログイン日数を1に設定
//             $user->consecutive_days = 1;
//         }

//         // 最終ログイン日時を更新
//         $user->last_login_at = $now;

//         // 変更を保存
//         $user->save();
//     }
// }