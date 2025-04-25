<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Habit; // Habitモデルをインポート
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Carbonをインポート

class CalendarControllernew extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // 認証が必要なメソッドに適用
    }

    /**
     * カレンダー全体を表示するメソッド
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function shownew(Request $request): View
    {
        // ログイン中のユーザーを取得
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // 年と月を取得
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        // 月初の日付を生成
        $startOfMonth = Carbon::createFromDate($year, $month, 1);

        // その月の日数と最初の曜日を計算
        $daysInMonth = $startOfMonth->daysInMonth;
        $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)

        // 当該月の habits を取得
        $habits = Habit::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->groupBy('date'); // 日付ごとにグループ化

        // 各日付の habits を整理
        $markedHabits = [];
        foreach ($habits as $date => $dailyHabits) {
            $markedHabits[$date] = [];
            foreach ($dailyHabits as $habit) {
                $markedHabits[$date][$habit->category] = true;
            }
        }

        return view('calendar.calendarnew', compact(
            'year',
            'month',
            'daysInMonth',
            'startDayOfWeek',
            'markedHabits'
        ));
    }
}