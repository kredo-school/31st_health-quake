<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habit; // Habitモデルをインポート
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // 認証が必要なメソッドに適用
    }

    /**
     * カレンダーページを表示するメソッド
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ログイン中のユーザーを取得
        $user = Auth::user();
        if (!$user) {
            return redirect('/login'); // ログインしていない場合はログインページにリダイレクト
        }

        // 最新の4件の習慣を取得（必要に応じて調整）
        $habits = Habit::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        /**
         * ここでは、'calendar' という名前のビューを返すように変更します。
         * このビューは、カレンダーを表示するためのBladeテンプレートです。
         * （※ 'calendar.blade.php' ファイルを作成する必要があります）
         */
        return view('calendar', compact('habits'));
    }
}