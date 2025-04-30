<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward; // 報酬モデル
use Illuminate\Support\Facades\Auth; // 認証機能
use Illuminate\Support\Facades\Storage; // ファイルストレージ

class RewardsController extends Controller
{
    /**
     * 報酬設定ページを表示
     */
    public function index()
    {
        // ログインチェック
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        // 現在ログインしているユーザーの報酬一覧を取得
        $rewards = Auth::user()->rewards;

        // ビューにデータを渡す
        return view('set-rewards', compact('rewards'));
    }

    /**
     * 新しい報酬を追加
     */
    public function store(Request $request)
    {
        // ログインチェック
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        // ユーザーの現在の報酬数をチェック
        $rewardCount = Auth::user()->rewards->count();
        if ($rewardCount >= 3) {
            return redirect()->route('rewards.index')->with('error', '報酬は最大3つまでしか設定できません');
        }

        // 入力値のバリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'level' => 'required|integer|min:1|max:5', // レベル1〜5
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 最大2MB
        ]);

        // 画像がアップロードされた場合、保存する
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reward_images', 'public');
        } else {
            $imagePath = null;
        }

        // ユーザーに関連付けた報酬をデータベースに保存
        Auth::user()->rewards->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'level' => $validated['level'],
            'image' => $imagePath,
        ]);

        return redirect()->route('rewards.index')->with('success', '報酬が追加されました！');
    }

    /**
     * 報酬編集フォームを表示
     */
    public function edit($id)
    {
        // ログインチェック
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        // 現在ログインしているユーザーに関連する報酬を取得
        $reward = Auth::user()->rewards->findOrFail($id);

        // 編集フォームを表示
        return view('edit-reward', compact('reward'));
    }

    /**
     * 報酬を更新
     */
    public function update(Request $request, $id)
    {
        // ログインチェック
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        // 現在ログインしているユーザーに関連する報酬を取得
        $reward = Auth::user()->rewards->findOrFail($id);

        // 入力値のバリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'level' => 'required|integer|min:1|max:5', // レベル1〜5
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 最大2MB
        ]);

        // 画像がアップロードされた場合、古い画像を削除して新しい画像を保存
        if ($request->hasFile('image')) {
            // 古い画像があれば削除
            if ($reward->image) {
                Storage::disk('public')->delete($reward->image);
            }
            $imagePath = $request->file('image')->store('reward_images', 'public');
        } else {
            // 画像が送信されなかった場合は既存の画像を維持
            $imagePath = $reward->image;
        }

        // 報酬を更新
        $reward->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'level' => $validated['level'],
            'image' => $imagePath,
        ]);

        return redirect()->route('rewards.index')->with('success', '報酬が更新されました！');
    }

    /**
     * 報酬を削除
     */
    public function destroy($id)
    {
        // ログインチェック
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        // 現在ログインしているユーザーに関連する報酬を取得
        $reward = Auth::user()->rewards->findOrFail($id);

        // 報酬に関連する画像があれば削除
        if ($reward->image) {
            Storage::disk('public')->delete($reward->image);
        }

        // 報酬を削除
        $reward->delete();

        return redirect()->route('rewards.index')->with('success', '報酬が削除されました！');
    }

    /**
     * ご褒美獲得ページを表示
     * レベルが3の倍数になったときに呼び出される
     */
    public function earned($level)
    {
        // ログインチェック
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        // レベルが3の倍数でない場合はカレンダーにリダイレクト
        if ($level % 3 != 0) {
            return redirect()->route('calendar.show', ['date' => now()->format('Y-m-d')]);
        }

        // 現在のユーザーを取得
        $user = Auth::user();

        // ユーザーが設定したご褒美を取得
        $userRewards = $user->rewards;

        // ご褒美がない場合はサンプルご褒美を使用
        if ($userRewards->isEmpty()) {
            $rewards = [
                [
                    'id' => 'sample_1',
                    'title' => 'Eat favorite food',
                    'description' => '好きな食べ物を食べる',
                    'level' => 5,
                    'image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38'
                ],
                [
                    'id' => 'sample_2',
                    'title' => 'Watch favorite anime',
                    'description' => '好きなアニメを見る',
                    'level' => 5,
                    'image' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131'
                ],
                [
                    'id' => 'sample_3',
                    'title' => 'Buy something nice',
                    'description' => '何か素敵なものを買う',
                    'level' => 5,
                    'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187'
                ]
            ];

            // サンプルからランダムに選択
            $randomIndex = array_rand($rewards);
            $reward = $rewards[$randomIndex];
        } else {
            // 実際のユーザーのご褒美からランダムに選択
            $randomReward = $userRewards->random();

            $reward = [
                'id' => $randomReward->id,
                'title' => $randomReward->title,
                'description' => $randomReward->description,
                'level' => $randomReward->level,
                'image' => $randomReward->image ? asset('storage/' . $randomReward->image) : 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38'
            ];
        }

        // 次のご褒美獲得レベル（次の3の倍数）を計算
        $nextRewardLevel = ($level + 3);

        // ご褒美獲得履歴をデータベースに記録（必要に応じて）
        $this->recordRewardEarned($user->id, $level, $reward['id'] ?? null);

        // ご褒美ページに必要なデータを渡す
        return view('reward_earned', [
            'currentLevel' => $level,
            'reward' => $reward,
            'nextRewardLevel' => $nextRewardLevel
        ]);
    }

    /**
     * ご褒美獲得履歴を記録（オプショナル機能）
     */
    private function recordRewardEarned($userId, $level, $rewardId)
    {
        // RewardHistoryモデルがある場合の処理
        // 必要に応じて実装する

        // 例：
        // RewardHistory::create([
        //     'user_id' => $userId,
        //     'reward_id' => $rewardId,
        //     'level' => $level,
        //     'earned_at' => now()
        // ]);
    }

    /**
     * ユーザーのレベルに基づいてご褒美ページにリダイレクトするかチェック
     * 他のコントローラーから呼び出すためのユーティリティメソッド
     */
    public function checkRewardEligibility($level)
    {
        // レベルが3の倍数の場合はご褒美獲得ページにリダイレクト
        if ($level % 3 == 0) {
            return redirect()->route('reward.earned', ['level' => $level]);
        }

        // そうでなければfalseを返す（通常の処理を続行）
        return false;
    }
}
