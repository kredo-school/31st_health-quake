<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @var string
     */
    protected $redirectTo = '/home'; 

    /**
     * @return string
     */
    public function username()
    {
        return 'username'; // 'email' ではなく 'username' を使用する場合
    }

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // ログアウト以外のメソッドはゲストのみアクセス可能
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // バリデーションルールを定義
        $this->validate($request, [
            'username' => 'required|string', // 'username' フィールドが必須かつ文字列であることを確認
            'password' => 'required|string', // 'password' フィールドが必須かつ文字列であることを確認
        ]);

        // 認証情報を取得
        $credentials = $request->only('username', 'password');

        // 認証を試行
        if (Auth::attempt($credentials)) {
            // 認証成功時の処理
            $user = Auth::user(); // 認証されたユーザーを取得
            $user->updateLoginStatus(); // 連続ログイン記録を更新

            // return redirect()->intended($this->redirectTo); // 指定されたリダイレクト先に遷移
            return redirect(route('home', absolute: false));
        }

        // 認証失敗時の処理
        return back()->withErrors([
            'username' => 'Username or password is not correct', // エラーメッセージを表示
        ]);
    }
}