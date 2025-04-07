<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habit; // Habitモデルをインポート
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // 認証が必要なメソッドに適用xxx
    }

    public function index()
    {
        // ログイン中のユーザーを取得
        $user = Auth::user();
        if (!$user) {
            return redirect('/login'); // ログインページにリダイレクト
        }

        // 最新の4件の習慣を取得
        $habits = Habit::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // ビューに渡す
        return view('routines.SetRoutine', compact('habits'));
    }
}
