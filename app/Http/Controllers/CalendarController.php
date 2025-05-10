<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Habit; // Habitモデルをインポート
use App\Models\CompletedHabit; // CompletedHabitモデルをインポート
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
        $user = Auth::user();
        if (!$user) {
            return redirect('/login'); // ログインしていない場合はログインページにリダイレクト
        }

        // 最新の4件の習慣を取得
        $habits = Habit::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

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
            $parsedDate = $this->parseDate($date);
            $year = $parsedDate->year;
            $month = $parsedDate->month;

            $user = Auth::user();
            if (!$user) {
                return redirect('/login'); // ログインしていない場合はログインページにリダイレクト
            }

            // 習慣データを取得
            $habitsData = $this->fetchHabitsForMonth($user->id, $year, $month);
            $activeHabits = $this->fetchActiveHabits($user->id);

            // 日付ごとの説明文を生成
            $descriptions = $this->buildDescriptions(
                $habitsData['habitsFromHabitTable'],
                $habitsData['habitsFromCompletedTable']
            );

            return view('calendar.show', [
                'date' => $parsedDate->format('Y-m-d'),
                'year' => $year,
                'month' => $month,
                'startDayOfWeek' => $parsedDate->startOfMonth()->dayOfWeek,
                'habits' => $habitsData['habitsFromHabitTable'],
                'completedHabits' => $habitsData['habitsFromCompletedTable'],
                'activeHabits' => $activeHabits,
                'descriptions' => $descriptions,
                'completedHabitId' => $request->query('completed_habit_id'),
                'today' => now()->format('Y-m-d'),
            ]);
        } catch (\Exception $e) {
            Log::error("Error in CalendarController: " . $e->getMessage());
            return back()->withErrors(['general' => '予期しないエラーが発生しました。']);
        }
    }

    /**
     * 特定の月のカレンダーデータを表示するメソッド
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function shownew(Request $request): View
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $startOfMonth = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $startDayOfWeek = $startOfMonth->dayOfWeek;

        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // 習慣データを取得
        $habitsData = $this->fetchHabitsForMonth($user->id, $year, $month);

        // 日付ごとのマークされた習慣を生成
        $markedHabits = [];
        foreach ($habitsData['habitsFromHabitTable'] as $habit) {
            $dateStr = $habit->date->format('Y-m-d');
            $markedHabits[$dateStr][$habit->category] = true;
        }
        foreach ($habitsData['habitsFromCompletedTable'] as $habit) {
            $dateStr = $habit->completed_date->format('Y-m-d');
            $markedHabits[$dateStr][$habit->category] = true;
        }

        return view('calendar.calendarnew', [
            'year' => $year,
            'month' => $month,
            'daysInMonth' => $daysInMonth,
            'startDayOfWeek' => $startDayOfWeek,
            'markedHabits' => $markedHabits,
            'habitsFromHabitTable' => $habitsData['habitsFromHabitTable'],
            'habitsFromCompletedTable' => $habitsData['habitsFromCompletedTable'],
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
            if (is_string($id) && strpos($id, 'completed_') === 0) {
                $completedId = substr($id, 10); // 'completed_' を除いた部分
                $habit = CompletedHabit::findOrFail($completedId);
            } else {
                $habit = Habit::findOrFail($id);
            }

            // 権限チェック
            if ($habit->user_id != Auth::id()) {
                return redirect()->back()->with('error', '他のユーザーの習慣は削除できません。');
            }

            $habit->delete();
            return redirect()->back()->with('success', '習慣が削除されました。');
        } catch (\Exception $e) {
            Log::error("Error deleting habit: " . $e->getMessage());
            return redirect()->back()->with('error', '習慣の削除中にエラーが発生しました。');
        }
    }

    /**
     * 日付を解析するプライベートメソッド
     * @param string|null $date
     * @return Carbon
     */
    private function parseDate($date)
    {
        return $date ? Carbon::parse($date) : Carbon::now();
    }

    /**
     * 月ごとの習慣データを取得するプライベートメソッド
     * @param int $userId
     * @param int $year
     * @param int $month
     * @return array
     */
    private function fetchHabitsForMonth($userId, $year, $month)
    {
        $habitsFromHabitTable = Habit::where('user_id', $userId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('is_completed', 1)
            ->get();

        $habitsFromCompletedTable = CompletedHabit::where('user_id', $userId)
            ->whereYear('completed_date', $year)
            ->whereMonth('completed_date', $month)
            ->get();

        return [
            'habitsFromHabitTable' => $habitsFromHabitTable,
            'habitsFromCompletedTable' => $habitsFromCompletedTable,
        ];
    }

    /**
     * 未完了の習慣を取得するプライベートメソッド
     * @param int $userId
     * @return mixed
     */
    private function fetchActiveHabits($userId)
    {
        return Habit::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('is_completed', '!=', 1)
                    ->orWhereNull('is_completed');
            })
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * 日付ごとの説明文を生成するプライベートメソッド
     * @param mixed $habitsFromHabitTable
     * @param mixed $habitsFromCompletedTable
     * @return array
     */
    private function buildDescriptions($habitsFromHabitTable, $habitsFromCompletedTable)
    {
        $descriptions = [];

        foreach ($habitsFromHabitTable as $habit) {
            $dateStr = $habit->date->format('Y-m-d');
            $this->addDescription($descriptions, $dateStr, $habit, 'habits');
        }

        foreach ($habitsFromCompletedTable as $habit) {
            $dateStr = $habit->completed_date->format('Y-m-d');
            $this->addDescription($descriptions, $dateStr, $habit, 'completed_habits');
        }

        return $descriptions;
    }

    /**
     * 説明文を追加するプライベートメソッド
     * @param array $descriptions
     * @param string $dateStr
     * @param mixed $habit
     * @param string $source
     */
    private function addDescription(&$descriptions, $dateStr, $habit, $source)
    {
        $color = $this->getCategoryColor($habit->category);

        if (!isset($descriptions[$dateStr])) {
            $descriptions[$dateStr] = [];
        }

        $isDuplicate = false;
        foreach ($descriptions[$dateStr] as $existingHabit) {
            if ($existingHabit['text'] === $habit->name) {
                $isDuplicate = true;
                break;
            }
        }

        if (!$isDuplicate) {
            $descriptions[$dateStr][] = [
                'text' => $habit->name,
                'color' => $color,
                'completed' => true,
                'habit_id' => $source === 'completed_habits' ? 'completed_' . $habit->id : $habit->id,
                'source' => $source,
            ];
        }
    }

    /**
     * カテゴリに基づいて色を決定するヘルパーメソッド
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
            return 'bg-gray-300'; // デフォルトの色
        }
    }
}