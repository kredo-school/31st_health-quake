<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 設定を取得（例: config/settings.php から取得する場合）
        $categoryName = config('settings.category_name', 'デフォルトカテゴリ名');

        return view('admin.categories.index', compact('categoryName'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // 設定を取得（例: config/settings.php から取得する場合）
        $categoryName = config('settings.category_name', 'デフォルトカテゴリ名');

        return view('admin.categories.edit', compact('categoryName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // バリデーション
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        // 設定を保存（例: .env ファイルに保存する場合）
        $path = base_path('.env');
        file_put_contents($path, "CATEGORY_NAME=" . $request->category_name);

        // 成功メッセージをセッションに保存
        return redirect()->route('admin.categories')->with('success', 'カテゴリ名を保存しました！');
    }
}