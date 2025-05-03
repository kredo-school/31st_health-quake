<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Habit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        // タブパラメータを取得（デフォルトはレベル）
        $type = $request->query('type', 'level');

        try {
            // ランキングタイプに基づいてデータを取得
            switch ($type) {
                case 'weekly':
                    $ranks = $this->getWeeklyRanking();
                    $rankingTitle = "週間ランキング";
                    break;
                case 'monthly':
                    $ranks = $this->getMonthlyRanking();
                    $rankingTitle = "月間ランキング";
                    break;
                case 'level':
                default:
                    $ranks = $this->getLevelRanking();
                    $rankingTitle = "レベルランキング";
                    break;
            }

            // 現在のユーザーのポジションを取得
            $userPosition = 0;
            foreach ($ranks as $index => $rank) {
                if ($rank['user_id'] === Auth::id()) {
                    $userPosition = $rank['position'];
                    break;
                }
            }

            // ビューにランキングデータを渡す
            return view('ranking', compact('ranks', 'type', 'rankingTitle', 'userPosition'));
        } catch (\Exception $e) {
            // エラーが発生した場合はレベルランキングにフォールバック
            $ranks = $this->getLevelRanking();
            $rankingTitle = "レベルランキング";
            $type = 'level';

            // 現在のユーザーのポジションを取得
            $userPosition = 0;
            foreach ($ranks as $index => $rank) {
                if ($rank['user_id'] === Auth::id()) {
                    $userPosition = $rank['position'];
                    break;
                }
            }

            return view('ranking', compact('ranks', 'type', 'rankingTitle', 'userPosition'));
        }
    }

    /**
     * レベルランキングのデータを取得
     */
    private function getLevelRanking()
    {
        // ユーザーテーブルのカラムを取得
        $columns = Schema::getColumnListing('users');

        // 必要なカラムのリスト
        $requiredColumns = ['id'];

        // nameカラムが存在すれば追加
        if (in_array('name', $columns)) {
            $requiredColumns[] = 'name';
        } elseif (in_array('username', $columns)) {
            // nameがなくusernameがあれば代わりに使用
            $requiredColumns[] = 'username';
        }

        // levelカラムが存在すれば追加
        if (in_array('level', $columns)) {
            $requiredColumns[] = 'level';
        }

        // 実際のユーザーデータを取得
        $users = User::select($requiredColumns)->get();

        // ユーザー情報を準備
        $users = $users->map(function ($user) use ($columns) {
            // ユーザー名を設定（nameカラムがなければemailなどを代替として使用）
            if (!isset($user->name)) {
                if (isset($user->username)) {
                    $user->name = $user->username;
                } elseif (isset($user->email)) {
                    $user->name = explode('@', $user->email)[0]; // メールアドレスのローカル部分を使用
                } else {
                    $user->name = "User {$user->id}"; // IDを使った汎用名
                }
            }

            // レベル情報を取得または計算
            if (!isset($user->level) || is_null($user->level)) {
                // 完了した習慣の数を取得
                $completedHabitsCount = Habit::where('user_id', $user->id)
                    ->where('is_completed', 1)
                    ->count();

                // レベルを計算（5つごとに1レベルアップ）
                $user->level = (int)($completedHabitsCount / 5) + 1;
            }

            return $user;
        });

        // レベル順に並べ替え
        $users = $users->sortByDesc('level');

        // ランキングデータを整形
        $ranks = [];
        $position = 1;

        foreach ($users as $user) {
            // アバター画像のURLをプロフィールから取得（なければプレースホルダーを使用）
            $avatar = asset('images/default-avatar.png'); // デフォルトのアバター画像

            // ユーザー画像がある場合はそれを使用
            if (Auth::id() === $user->id && Auth::user() && isset(Auth::user()->profile_photo_url)) {
                $avatar = Auth::user()->profile_photo_url;
            }

            // ユーザー名（現在のユーザーなら「あなた」と表示）
            $displayName = $user->id === Auth::id() ? 'あなた' : $user->name;

            $ranks[] = [
                'user_id' => $user->id,
                'avatar' => $avatar,
                'position' => $position,
                'name' => $displayName,
                'points' => $user->level,
                'label' => 'レベル'
            ];

            $position++;
        }

        return $ranks;
    }

    /**
     * 週間ランキングのデータを取得
     */
    private function getWeeklyRanking()
    {
        // 週の開始日と終了日を取得
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // habitsテーブルのカラムを確認
        $hasCompletedAt = Schema::hasColumn('habits', 'completed_at');

        // この週に完了した習慣の数をユーザーごとに集計
        $query = Habit::where('is_completed', 1);

        if ($hasCompletedAt) {
            // completed_atカラムがある場合は日付で絞り込み
            $query->whereBetween('completed_at', [$startOfWeek, $endOfWeek]);
        } else {
            // completed_atカラムがない場合は作成日またはlast_completedで代用
            if (Schema::hasColumn('habits', 'last_completed')) {
                $query->whereBetween('last_completed', [$startOfWeek, $endOfWeek]);
            } else {
                // 両方ない場合は絞り込みなし
                $query->whereDate('created_at', '>=', $startOfWeek)
                    ->whereDate('created_at', '<=', $endOfWeek);
            }
        }

        $weeklyStats = $query->select('user_id', DB::raw('count(*) as completed_count'))
            ->groupBy('user_id')
            ->orderByDesc('completed_count')
            ->get();

        // 必要なカラムを取得
        $columns = ['id'];
        if (Schema::hasColumn('users', 'name')) {
            $columns[] = 'name';
        } elseif (Schema::hasColumn('users', 'username')) {
            $columns[] = 'username';
        }

        // ユーザー情報を取得
        $users = User::whereIn('id', $weeklyStats->pluck('user_id'))
            ->select($columns)
            ->get()
            ->keyBy('id');

        // ユーザー情報を準備（名前の設定）
        $users = $users->map(function ($user) {
            if (!isset($user->name)) {
                if (isset($user->username)) {
                    $user->name = $user->username;
                } elseif (isset($user->email)) {
                    $user->name = explode('@', $user->email)[0];
                } else {
                    $user->name = "User {$user->id}";
                }
            }
            return $user;
        });

        // ランキングデータを整形
        $ranks = [];
        $position = 1;

        foreach ($weeklyStats as $stat) {
            $user = $users[$stat->user_id] ?? null;

            if ($user) {
                // アバター画像のURLをプロフィールから取得（なければプレースホルダーを使用）
                $avatar = asset('images/default-avatar.png'); // デフォルトのアバター画像

                // ユーザー画像がある場合はそれを使用
                if (Auth::id() === $user->id && Auth::user() && isset(Auth::user()->profile_photo_url)) {
                    $avatar = Auth::user()->profile_photo_url;
                }

                // ユーザー名（現在のユーザーなら「あなた」と表示）
                $displayName = $user->id === Auth::id() ? 'あなた' : $user->name;

                $ranks[] = [
                    'user_id' => $user->id,
                    'avatar' => $avatar,
                    'position' => $position,
                    'name' => $displayName,
                    'points' => $stat->completed_count,
                    'label' => '週間達成数'
                ];

                $position++;
            }
        }

        // 現在のユーザーがランキングに含まれていない場合は追加
        if (!collect($ranks)->pluck('user_id')->contains(Auth::id())) {
            // この週に完了した現在のユーザーの習慣数を取得
            $query = Habit::where('user_id', Auth::id())
                ->where('is_completed', 1);

            if ($hasCompletedAt) {
                $query->whereBetween('completed_at', [$startOfWeek, $endOfWeek]);
            } else {
                if (Schema::hasColumn('habits', 'last_completed')) {
                    $query->whereBetween('last_completed', [$startOfWeek, $endOfWeek]);
                } else {
                    $query->whereDate('created_at', '>=', $startOfWeek)
                        ->whereDate('created_at', '<=', $endOfWeek);
                }
            }

            $userCompletedCount = $query->count();

            // アバター画像のURLをプロフィールから取得
            $avatar = asset('images/default-avatar.png');
            if (Auth::user() && isset(Auth::user()->profile_photo_url)) {
                $avatar = Auth::user()->profile_photo_url;
            }

            $ranks[] = [
                'user_id' => Auth::id(),
                'avatar' => $avatar,
                'position' => count($ranks) + 1,
                'name' => 'あなた',
                'points' => $userCompletedCount,
                'label' => '週間達成数'
            ];
        }

        return $ranks;
    }

    /**
     * 月間ランキングのデータを取得
     */
    private function getMonthlyRanking()
    {
        // 月の開始日と終了日を取得
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // habitsテーブルのカラムを確認
        $hasCompletedAt = Schema::hasColumn('habits', 'completed_at');

        // この月に完了した習慣の数をユーザーごとに集計
        $query = Habit::where('is_completed', 1);

        if ($hasCompletedAt) {
            // completed_atカラムがある場合は日付で絞り込み
            $query->whereBetween('completed_at', [$startOfMonth, $endOfMonth]);
        } else {
            // completed_atカラムがない場合は作成日またはlast_completedで代用
            if (Schema::hasColumn('habits', 'last_completed')) {
                $query->whereBetween('last_completed', [$startOfMonth, $endOfMonth]);
            } else {
                // 両方ない場合は作成日で代用
                $query->whereDate('created_at', '>=', $startOfMonth)
                    ->whereDate('created_at', '<=', $endOfMonth);
            }
        }

        $monthlyStats = $query->select('user_id', DB::raw('count(*) as completed_count'))
            ->groupBy('user_id')
            ->orderByDesc('completed_count')
            ->get();

        // 必要なカラムを取得
        $columns = ['id'];
        if (Schema::hasColumn('users', 'name')) {
            $columns[] = 'name';
        } elseif (Schema::hasColumn('users', 'username')) {
            $columns[] = 'username';
        }

        // ユーザー情報を取得
        $users = User::whereIn('id', $monthlyStats->pluck('user_id'))
            ->select($columns)
            ->get()
            ->keyBy('id');

        // ユーザー情報を準備（名前の設定）
        $users = $users->map(function ($user) {
            if (!isset($user->name)) {
                if (isset($user->username)) {
                    $user->name = $user->username;
                } elseif (isset($user->email)) {
                    $user->name = explode('@', $user->email)[0];
                } else {
                    $user->name = "User {$user->id}";
                }
            }
            return $user;
        });

        // ランキングデータを整形
        $ranks = [];
        $position = 1;

        foreach ($monthlyStats as $stat) {
            $user = $users[$stat->user_id] ?? null;

            if ($user) {
                // アバター画像のURLをプロフィールから取得（なければプレースホルダーを使用）
                $avatar = asset('images/default-avatar.png'); // デフォルトのアバター画像

                // ユーザー画像がある場合はそれを使用
                if (Auth::id() === $user->id && Auth::user() && isset(Auth::user()->profile_photo_url)) {
                    $avatar = Auth::user()->profile_photo_url;
                }

                // ユーザー名（現在のユーザーなら「あなた」と表示）
                $displayName = $user->id === Auth::id() ? 'あなた' : $user->name;

                $ranks[] = [
                    'user_id' => $user->id,
                    'avatar' => $avatar,
                    'position' => $position,
                    'name' => $displayName,
                    'points' => $stat->completed_count,
                    'label' => '月間達成数'
                ];

                $position++;
            }
        }

        // 現在のユーザーがランキングに含まれていない場合は追加
        if (!collect($ranks)->pluck('user_id')->contains(Auth::id())) {
            // この月に完了した現在のユーザーの習慣数を取得
            $query = Habit::where('user_id', Auth::id())
                ->where('is_completed', 1);

            if ($hasCompletedAt) {
                $query->whereBetween('completed_at', [$startOfMonth, $endOfMonth]);
            } else {
                if (Schema::hasColumn('habits', 'last_completed')) {
                    $query->whereBetween('last_completed', [$startOfMonth, $endOfMonth]);
                } else {
                    $query->whereDate('created_at', '>=', $startOfMonth)
                        ->whereDate('created_at', '<=', $endOfMonth);
                }
            }

            $userCompletedCount = $query->count();

            // アバター画像のURLをプロフィールから取得
            $avatar = asset('images/default-avatar.png');
            if (Auth::user() && isset(Auth::user()->profile_photo_url)) {
                $avatar = Auth::user()->profile_photo_url;
            }

            $ranks[] = [
                'user_id' => Auth::id(),
                'avatar' => $avatar,
                'position' => count($ranks) + 1,
                'name' => 'あなた',
                'points' => $userCompletedCount,
                'label' => '月間達成数'
            ];
        }

        return $ranks;
    }
}
