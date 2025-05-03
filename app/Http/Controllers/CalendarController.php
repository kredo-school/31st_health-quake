<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Habit; // Habitモデルをインポート
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
     * @param Request $request
     * @param string|null $date
     * @return \Illuminate\View\View
     */
    public function show(Request $request, string $date = null): View
    {
        try {
            // 日付が指定されていない場合は今日の日付を使用
            if ($date === null) {
                $date = Carbon::now()->format('Y-m-d');
            }

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

            // カレンダー表示用の完了済み習慣のみを取得
            $allHabits = Habit::where('user_id', $user->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('is_completed', 1) // 完了済みの習慣のみを表示
                ->get();

            // 未完了の習慣のみを取得（リスト表示用）
            $activeHabits = Habit::where('user_id', $user->id)
                ->where(function ($query) {
                    $query->where('is_completed', '!=', 1)
                        ->orWhereNull('is_completed');
                })
                ->orderBy('date', 'desc')
                ->get();

            // デバッグ情報
            Log::debug("Total completed habits: " . $allHabits->count() . ", Active habits: " . $activeHabits->count());

            // 月初の日付を生成
            $startOfMonth = Carbon::create($year, $month, 1);
            $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)

            // 日付ごとに習慣を整理
            $descriptions = [];

            // 各習慣を処理
            foreach ($allHabits as $habit) {
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

                // 習慣をdescriptions配列に追加
                $descriptions[$dateStr][] = [
                    'text' => $habit->name,
                    'color' => $color,
                    'completed' => true, // すべて完了済み
                    'habit_id' => $habit->id
                ];

                // デバッグログ
                Log::debug("Added habit to descriptions - ID: {$habit->id}, Name: {$habit->name}, Date: {$dateStr}");
            }

            // リクエストから完了したタスクIDを取得
            $completedHabitId = $request->query('completed_habit_id');

            // セッションから完了したhabit情報を取得
            $sessionCompletedHabitId = session('completed_habit_id');

            // 今日の日付
            $today = Carbon::now()->format('Y-m-d');

            return view('calendar.show', [
                'date' => $parsedDate->format('Y-m-d'),
                'year' => $year,
                'month' => $month,
                'startDayOfWeek' => $startDayOfWeek,
                'habits' => $allHabits, // 完了済みの習慣をカレンダーに表示
                'activeHabits' => $activeHabits, // 未完了の習慣を別変数として保持
                'descriptions' => $descriptions,
                'completedHabitId' => $completedHabitId ?: $sessionCompletedHabitId,
                'today' => $today
            ]);
        } catch (\Exception $e) {
            Log::error('Calendar error: ' . $e->getMessage());
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

        // その月の完了済み習慣データのみを取得
        $habits = Habit::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('is_completed', 1) // 完了済みの習慣のみを表示
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

    /**
     * カレンダーから習慣を削除するメソッド
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteHabit($id)
    {
        // 指定されたIDの習慣を取得
        $habit = Habit::findOrFail($id);

        // 権限チェック（自分の習慣のみ削除可能）
        if ($habit->user_id != Auth::id()) {
            return redirect()->back()
                ->with('error', '他のユーザーの習慣は削除できません。');
        }

        // 習慣を削除
        $habit->delete();

        // 元のページにリダイレクト
        return redirect()->back()
            ->with('success', '習慣が削除されました。');
    }
}
