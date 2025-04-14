<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Habit; // Habitモデルをインポート
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Carbon\Carbon as CarbonInstance;

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
        return view('calendar.calendarnew', compact('habits'));
    }

    /**
     * 特定の日付のカレンダーデータを表示するメソッド
     * @param string $date
     * @return \Illuminate\View\View
     */
    public function show(string $date): View
    {
        // 日付を解析
        $parsedDate = now()->parse($date);

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

        return view('calendar.calendarnew', [
            'date' => $parsedDate->format('Y-m-d'), // 日付をビューに渡す
        ]);
    }

    /**
     * 特定の月のカレンダーデータを表示するメソッド
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function shownew(Request $request): View
    {
        // 日付を解析
        $parsedDate = now();

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

        // 年と月を取得
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        // 月初の日付を生成
        $startOfMonth = Carbon::createFromDate($year, $month, 1);

        // その月の日数と最初の曜日を計算
        $daysInMonth = $startOfMonth->daysInMonth;
        $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)

        // セッションから習慣データを取得（例: モックデータを使用）
        $markedHabits = session('marked_habits', []);

        // 現在の日付をフォーマット
        $date = $parsedDate->format('Y-m-d');

        // ダミーデータ（実際にはデータベースから取得）
        $descriptions = [
            '2025-04-05' => [
                ['text' => 'Meeting with client', 'color' => 'bg-yellow-300'],
                ['text' => 'Team review', 'color' => 'bg-pink-300'],
            ],
            '2025-04-12' => [
                ['text' => 'Workout day', 'color' => 'bg-red-300'],
            ],
            '2025-04-15' => [
                ['text' => 'Project deadline', 'color' => 'bg-blue-300'],
                ['text' => 'Submit report', 'color' => 'bg-green-200'],
            ],
        ];

        return view('calendar.calendarnew', compact(
            'date',
            'descriptions',
            'year',
            'month',
            'daysInMonth',
            'startDayOfWeek',
            'markedHabits'
        ));
    }
}