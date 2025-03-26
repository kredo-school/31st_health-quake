<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habit;

class HabitController extends Controller
{
    /**
     * 常に最新の4つの習慣を取得して表示
     */
    public function index()
    {
        // 最新の4件の習慣を取得
        $habits = Habit::orderBy('created_at', 'desc')->take(4)->get();

        // ビューに渡す
        return view('routines.SetRoutine', compact('habits'));
    }

    /**
     * 常習を保存
     */
    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // 常習を保存
        Habit::create($validatedData);

        // 成功メッセージをセッションに保存
        session()->flash('success', 'Habit has been saved successfully.');

        // 一覧画面に戻る
        return redirect()->route('set-routine');
    }
}
