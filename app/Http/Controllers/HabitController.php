<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Habit;
class HabitController extends Controller
{
    public function destroy($id)
    {
        // 認証済みユーザーを取得
        $user = Auth::user()->id;

        // 該当の習慣を検索
        $habit = Habit::where('id', $id)->where('user_id', $user)->first();
        if (!$habit) {
            return redirect()->route('set-routine')->with('error', 'Habit not found or you do not have permission to delete this habit');
        }
        // 習慣を削除
        $habit->delete();
        return redirect()->route('set-routine')->with('success', 'Habit deleted successfully');
    }
    /**
     * 常に最新の4つの習慣を取得して表示S
     */
    public function index()
    {
        // 最新の4件の習慣を取得
        $habits = Habit::where('user_id', auth()->id()) // ログイン中のユーザーのみの習慣を取得
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        // ビューに渡す
        return view('routines.SetRoutine', compact('habits'));
    }
    /**
     * 習慣を保存
     */
    public function store(Request $request)
    {

        // バリデーション
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
        // 現在の認証ユーザーのIDを追加
        $validatedData['user_id'] = Auth::user()->id;
        // 常習を保存
        Habit::create($validatedData);
        // 成功メッセージをセッションに保存
        session()->flash('success', 'Habit has been saved successfully.');
        // 一覧画面に戻る
        return redirect()->route('set-routine');
    }
}

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Habit;

// class HabitController extends Controller
// {
//     /**
//      * 常に最新の4つの習慣を取得して表示
//      */
//     public function index()
//     {
//         // 最新の4件の習慣を取得
//         $habits = Habit::orderBy('created_at', 'desc')->take(4)->get();

//         // ビューに渡す
//         return view('routines.SetRoutine', compact('habits'));
//     }

//     /**
//      * 常習を保存
//      */
//     public function store(Request $request)
//     {
//         // バリデーション
//         $validatedData = $request->validate([
//             'name' => 'required|string|max:255',
//             'category' => 'required|string|max:255',
//             'date' => 'required|date',
//         ]);
//         // 現在の認証ユーザーのIDを追加
//         $validatedData['user_id'] = auth()->id();
//         // 常習を保存
//         Habit::create($validatedData);
//         // 成功メッセージをセッションに保存
//         session()->flash('success', 'Habit has been saved successfully.');
//         // 一覧画面に戻る
//         return redirect()->route('set-routine');
//     }
