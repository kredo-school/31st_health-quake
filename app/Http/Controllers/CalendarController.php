<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Habit; // Habitモデルをインポート
use App\Models\CompletedHabit; // CompletedHabitモデルをインポート（追加）
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

            // 1. Habitテーブルから完了済み習慣を取得
            $habitsFromHabitTable = Habit::where('user_id', $user->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('is_completed', 1) // 完了済みの習慣のみを表示
                ->get();

            // 2. CompletedHabitテーブルからも完了済み習慣を取得（追加）
            $habitsFromCompletedTable = CompletedHabit::where('user_id', $user->id)
                ->whereYear('completed_date', $year)
                ->whereMonth('completed_date', $month)
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
            Log::debug("Total habits from Habit table: " . $habitsFromHabitTable->count());
            Log::debug("Total habits from CompletedHabit table: " . $habitsFromCompletedTable->count());
            Log::debug("Active habits: " . $activeHabits->count());

            // 月初の日付を生成
            $startOfMonth = Carbon::create($year, $month, 1);
            $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)

            // 日付ごとに習慣を整理
            $descriptions = [];

            // Habitテーブルの習慣を処理
            foreach ($habitsFromHabitTable as $habit) {
                $dateStr = $habit->date->format('Y-m-d');
                $color = $this->getCategoryColor($habit->category);

                if (!isset($descriptions[$dateStr])) {
                    $descriptions[$dateStr] = [];
                }

                // 習慣をdescriptions配列に追加
                $descriptions[$dateStr][] = [
                    'text' => $habit->name,
                    'color' => $color,
                    'completed' => true,
                    'habit_id' => $habit->id,
                    'source' => 'habits'
                ];

                Log::debug("Added habit from Habits table - ID: {$habit->id}, Name: {$habit->name}, Date: {$dateStr}");
            }

            // CompletedHabitテーブルの習慣を処理（追加）
            foreach ($habitsFromCompletedTable as $habit) {
                $dateStr = $habit->completed_date->format('Y-m-d');
                $color = $this->getCategoryColor($habit->category);

                if (!isset($descriptions[$dateStr])) {
                    $descriptions[$dateStr] = [];
                }

                // 重複チェック（同じ日に同じ名前の習慣がある場合は追加しない）
                $isDuplicate = false;
                foreach ($descriptions[$dateStr] as $existingHabit) {
                    if ($existingHabit['text'] === $habit->name) {
                        $isDuplicate = true;
                        break;
                    }
                }

                if (!$isDuplicate) {
                    // 習慣をdescriptions配列に追加
                    $descriptions[$dateStr][] = [
                        'text' => $habit->name,
                        'color' => $color,
                        'completed' => true,
                        'habit_id' => 'completed_' . $habit->id,
                        'source' => 'completed_habits'
                    ];

                    Log::debug("Added habit from CompletedHabits - ID: {$habit->id}, Name: {$habit->name}, Date: {$dateStr}");
                }
            }

            // リクエストとセッションから完了したタスクIDを取得
            $completedHabitId = $request->query('completed_habit_id');
            $sessionCompletedHabitId = session('completed_habit_id');

            // 今日の日付
            $today = Carbon::now()->format('Y-m-d');

            // 全てのハビットをマージして返す（両方のテーブルからの習慣）
            $allHabits = $habitsFromHabitTable->concat($habitsFromCompletedTable);

            return view('calendar.show', [
                'date' => $parsedDate->format('Y-m-d'),
                'year' => $year,
                'month' => $month,
                'startDayOfWeek' => $startDayOfWeek,
                'habits' => $habitsFromHabitTable,
                'completedHabits' => $habitsFromCompletedTable, // 追加：CompletedHabitテーブルからの習慣
                'allHabits' => $allHabits, // 追加：両方のテーブルからの習慣
                'activeHabits' => $activeHabits,
                'descriptions' => $descriptions,
                'completedHabitId' => $completedHabitId ?: $sessionCompletedHabitId,
                'today' => $today
            ]);
        } catch (\Exception $e) {
            Log::error('Calendar error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->withErrors(['date' => 'Invalid date format. Please provide a valid date: ' . $e->getMessage()]);
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

        // 1. Habitテーブルから完了済み習慣を取得
        $habitsFromHabitTable = Habit::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('is_completed', 1)
            ->get();

        // 2. CompletedHabitテーブルからも完了済み習慣を取得（追加）
        $habitsFromCompletedTable = CompletedHabit::where('user_id', $user->id)
            ->whereYear('completed_date', $year)
            ->whereMonth('completed_date', $month)
            ->get();

        // 両方のソースからの習慣をマージ
        $markedHabits = [];

        // Habitテーブルからの習慣を処理
        foreach ($habitsFromHabitTable as $habit) {
            $dateStr = $habit->date->format('Y-m-d');
            $markedHabits[$dateStr][$habit->category] = true;
        }

        // CompletedHabitテーブルからの習慣を処理（追加）
        foreach ($habitsFromCompletedTable as $habit) {
            $dateStr = $habit->completed_date->format('Y-m-d');
            $markedHabits[$dateStr][$habit->category] = true;
        }

        return view('calendar.calendarnew', [
            'year' => $year,
            'month' => $month,
            'daysInMonth' => $daysInMonth,
            'startDayOfWeek' => $startDayOfWeek,
            'markedHabits' => $markedHabits,
            'habitsFromHabitTable' => $habitsFromHabitTable,
            'habitsFromCompletedTable' => $habitsFromCompletedTable,
        ]);
    }

    /**
     * カレンダーから習慣を削除するメソッド
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteHabit($id)
    {
        try {
            // IDが 'completed_' で始まる場合はCompletedHabitテーブルから削除
            if (is_string($id) && strpos($id, 'completed_') === 0) {
                $completedId = substr($id, 10); // 'completed_' を除いた部分
                $habit = CompletedHabit::findOrFail($completedId);

                // 権限チェック
                if ($habit->user_id != Auth::id()) {
                    return redirect()->back()
                        ->with('error', '他のユーザーの習慣は削除できません。');
                }

                // 習慣を削除
                $habit->delete();
                Log::debug("Deleted habit from CompletedHabits - ID: {$completedId}");
            } else {
                // 通常のHabitテーブルから削除
                $habit = Habit::findOrFail($id);

                // 権限チェック
                if ($habit->user_id != Auth::id()) {
                    return redirect()->back()
                        ->with('error', '他のユーザーの習慣は削除できません。');
                }

                // 習慣を削除
                $habit->delete();
                Log::debug("Deleted habit from Habits table - ID: {$id}");
            }

            // 元のページにリダイレクト
            return redirect()->back()
                ->with('success', '習慣が削除されました。');
        } catch (\Exception $e) {
            Log::error("Error deleting habit: " . $e->getMessage());
            return redirect()->back()
                ->with('error', '習慣の削除中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    /**
     * カテゴリに基づいて色を決定するヘルパーメソッド（追加）
     * @param string $category
     * @return string
     */
    private function getCategoryColor($category)
    {
        $lowerCategory = strtolower($category);

        if (strpos($lowerCategory, 'exercise') !== false) {
            return 'bg-red-400';  // Exerciseは赤
        } elseif (strpos($lowerCategory, 'nutrition') !== false) {
            return 'bg-green-400';  // Nutritionは緑
        } elseif (strpos($lowerCategory, 'sleep') !== false) {
            return 'bg-blue-400';  // Sleepは青
        } elseif (strpos($lowerCategory, 'other') !== false) {
            return 'bg-purple-400';  // Otherは紫
        } else {
            // デフォルトの色
            return 'bg-gray-300';
        }
    }
}
