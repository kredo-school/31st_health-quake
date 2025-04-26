<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Habit; // Habitモデルをインポート
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
    public function index(): View
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

        // カレンダー用のビューを返す
        return view('calendar.calendarnew', compact('habits'));
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
            $parsedDate = Carbon::parse($date);

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
                ->get();

            // 月初の日付を生成
            $startOfMonth = Carbon::create($year, $month, 1);
            $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)

            // その月の habit を取得（年と月で絞り込み）
            $habits1 = Habit::where('user_id', $user->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();

            // 日付ごとに習慣を整理
            $descriptions = [];

            // 各習慣を処理
            foreach ($habits1 as $habit) {
                $dateStr = $habit->date->format('Y-m-d');

                // カテゴリに基づいて色を決定
                $color = '';
                if ($habit->category == 'exercise' || $habit->category == 'Exercise Category') {
                    $color = 'bg-red-400';  // Exerciseは赤
                } elseif ($habit->category == 'nutrition' || $habit->category == 'Nutrition Category') {
                    $color = 'bg-green-400';  // Nutritionは緑
                } elseif ($habit->category == 'sleep' || $habit->category == 'Sleep Category') {
                    $color = 'bg-blue-400';  // Sleepは青
                } elseif ($habit->category == 'other' || $habit->category == 'Other Categories') {
                    $color = 'bg-purple-400';  // Otherは紫
                } else {
                    // デフォルトの色
                    $color = 'bg-gray-300';
                }

                if (!isset($descriptions[$dateStr])) {
                    $descriptions[$dateStr] = [];
                }

                $descriptions[$dateStr][] = [
                    'text' => $habit->name,
                    'color' => $color,
                ];
            }

            // デバッグ用
            // dd($descriptions);

            return view('calendar.show', [
                'date' => $parsedDate->format('Y-m-d'), // 日付をビューに渡す
                'year' => $year, // 年をビューに渡す
                'month' => $month, // 月をビューに渡す
                'startDayOfWeek' => $startDayOfWeek, // 月初の曜日をビューに渡す
                'habits' => $habits, // 習慣データをビューに渡す
                'descriptions' => $descriptions,
            ]);
        } catch (\Exception $e) {
            // 不正な日付の場合、エラーメッセージを表示
            dd($e);
            return back()->withErrors(['date' => 'Invalid date format. Please provide a valid date.']);
        }
    }

    /**
     * 特定の月のカレンダーデータを表示するメソッド
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function shownew(Request $request): View
    {
        // 年と月を取得（デフォルトは現在の年月）
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        // 月初の日付を生成
        $startOfMonth = Carbon::createFromDate($year, $month, 1);

        // その月の日数と最初の曜日を計算
        $daysInMonth = $startOfMonth->daysInMonth;
        $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)

        // ログイン中のユーザーを取得
        $user = Auth::user();
        if (!$user) {
            return redirect('/login'); // ログインしていない場合はログインページにリダイレクト
        }

        // その月の習慣データを取得
        $habits = Habit::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // 各 habit の category を配列に格納
        $markedHabits = [];
        foreach ($habits as $habit) {
            $dateStr = $habit->date->format('Y-m-d');
            $markedHabits[$dateStr][$habit->category] = true;
        }

        return view('calendar.calendarnew', [
            'year' => $year,
            'month' => $month,
            'daysInMonth' => $daysInMonth,
            'startDayOfWeek' => $startDayOfWeek,
            'markedHabits' => $markedHabits,
        ]);
    }
}
