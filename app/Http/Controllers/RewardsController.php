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
}