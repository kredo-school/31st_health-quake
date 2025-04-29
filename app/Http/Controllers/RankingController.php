<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        // タブパラメータを取得（デフォルトはレベル）
        $type = $request->query('type', 'level');

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

        // 現在のユーザーが何位か（仮にユーザーIDが4の場合）
        $userPosition = 4; // 仮の値

        // ビューにランキングデータを渡す
        return view('ranking', compact('ranks', 'type', 'rankingTitle', 'userPosition'));
    }

    /**
     * レベルランキングのデータを取得（仮）
     */
    private function getLevelRanking()
    {
        // 実際にはDB等からレベルデータを取得するロジック
        return [
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 1, 'name' => 'レベルユーザー1', 'points' => 42, 'label' => 'レベル'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 2, 'name' => 'レベルユーザー2', 'points' => 38, 'label' => 'レベル'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 3, 'name' => 'レベルユーザー3', 'points' => 35, 'label' => 'レベル'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 4, 'name' => 'あなた', 'points' => 30, 'label' => 'レベル'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 5, 'name' => 'レベルユーザー5', 'points' => 28, 'label' => 'レベル'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 6, 'name' => 'レベルユーザー6', 'points' => 25, 'label' => 'レベル'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 7, 'name' => 'レベルユーザー7', 'points' => 22, 'label' => 'レベル'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 8, 'name' => 'レベルユーザー8', 'points' => 18, 'label' => 'レベル'],
        ];
    }

    /**
     * 週間ランキングのデータを取得（仮）
     */
    private function getWeeklyRanking()
    {
        // 週の開始日と終了日を取得
        $startOfWeek = Carbon::now()->startOfWeek()->format('m/d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('m/d');
        $dateRange = "{$startOfWeek}～{$endOfWeek}";

        // 実際にはDB等から週間達成数データを取得するロジック
        return [
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 1, 'name' => '週間ユーザー1', 'points' => 24, 'label' => '週間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 2, 'name' => '週間ユーザー2', 'points' => 22, 'label' => '週間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 3, 'name' => '週間ユーザー3', 'points' => 20, 'label' => '週間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 4, 'name' => 'あなた', 'points' => 18, 'label' => '週間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 5, 'name' => '週間ユーザー5', 'points' => 15, 'label' => '週間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 6, 'name' => '週間ユーザー6', 'points' => 12, 'label' => '週間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 7, 'name' => '週間ユーザー7', 'points' => 10, 'label' => '週間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 8, 'name' => '週間ユーザー8', 'points' => 8, 'label' => '週間達成数'],
        ];
    }

    /**
     * 月間ランキングのデータを取得（仮）
     */
    private function getMonthlyRanking()
    {
        // 月の開始日と終了日を取得
        $startOfMonth = Carbon::now()->startOfMonth()->format('m/d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('m/d');
        $dateRange = "{$startOfMonth}～{$endOfMonth}";

        // 実際にはDB等から月間達成数データを取得するロジック
        return [
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 1, 'name' => '月間ユーザー1', 'points' => 90, 'label' => '月間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 2, 'name' => '月間ユーザー2', 'points' => 85, 'label' => '月間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 3, 'name' => '月間ユーザー3', 'points' => 82, 'label' => '月間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 4, 'name' => 'あなた', 'points' => 78, 'label' => '月間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 5, 'name' => '月間ユーザー5', 'points' => 70, 'label' => '月間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 6, 'name' => '月間ユーザー6', 'points' => 65, 'label' => '月間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 7, 'name' => '月間ユーザー7', 'points' => 60, 'label' => '月間達成数'],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 8, 'name' => '月間ユーザー8', 'points' => 55, 'label' => '月間達成数'],
        ];
    }
}
