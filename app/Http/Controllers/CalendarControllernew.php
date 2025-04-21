<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Habit; // Habitモデルをインポート
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // 認証が必要なメソッドに適用
    }

    /**
     * 特定の日付のカレンダーデータを表示するメソッド
     * @param string $date
     * @return \Illuminate\View\View
     */
    public function show(string $date): View
    {
        try {
            // 日付を解析
            $parsedDate = now()->parse($date);

            // 年と月を取得
            $year = $parsedDate->year;
            $month = $parsedDate->month;

            // ログイン中のユーザーを取得
            $user = Auth::user();
            if (!$user) {
                return redirect('/login'); // ログインしていない場合はログインページにリダイレクト
            }

            // 該当日付の habit を取得
            $habits = Habit::where('user_id', $user->id)
                ->where('date', $parsedDate->format('Y-m-d'))
                ->get();

            // 各 habit の category をセッションに保存
            $categories = [];
            foreach ($habits as $habit) {
                $categories[$habit->category] = true;
            }

            session(['marked_habits_' . $parsedDate->format('Y-m-d') => $categories]);

            return view('calendar.show', [
                'date' => $parsedDate->format('Y-m-d'), // 日付をビューに渡す
                'year' => $year,
                'month' => $month,
            ]);
        } catch (\Exception $e) {
            // 無効な日付の場合、エラーページを表示
            abort(404, 'Invalid date format.');
        }
    }

    /**
     * カレンダー全体を表示するメソッド
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function shownew(Request $request): View
    {
        // 年と月を取得
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        // ログイン中のユーザーを取得
        $user = Auth::user();
        if (!$user) {
            return redirect('/login'); // ログインしていない場合はログインページにリダイレクト
        }

        // 該当月の habit を取得
        $habits = Habit::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // 各 habit の category をセッションに保存
        $categories = [];
        foreach ($habits as $habit) {
            $categories[$habit->category] = true;
        }

        session(['marked_habits_' . $year . '-' . $month => $categories]);

        // カレンダーの最初の日の曜日を計算 (0: 日曜, 6: 土曜)
        $startOfMonth = \Carbon\Carbon::create($year, $month, 1);
        $startDayOfWeek = $startOfMonth->dayOfWeek;

        // その月の日数を取得
        $daysInMonth = $startOfMonth->daysInMonth;

        return view('calendar.calendarnew', [
            'year' => $year,
            'month' => $month,
            'startDayOfWeek' => $startDayOfWeek,
            'daysInMonth' => $daysInMonth,
        ]);
    }
}