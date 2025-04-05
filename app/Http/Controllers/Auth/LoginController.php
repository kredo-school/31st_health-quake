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
     * ログイン後のリダイレクト先を指定
     *
     * このプロパティは、ログイン成功後に遷移するパスを指定します。
     * ここでは /dashboard に遷移するように設定しています。
     *
     * @var string
     */
    protected $redirectTo = '/home'; // ログイン後に遷移するパスを /dashboard に変更

    /**
     * 認証に使用するカラムを指定（デフォルトは'email'）
     *
     * Laravelのデフォルトでは'email'を使用しますが、
     * ここでは 'username' を使用するように変更しています。
     *
     * @return string
     */
    public function username()
    {
        return 'username'; // 'email' ではなく 'username' を使用する場合
    }

    /**
     * Create a new controller instance.
     *
     * コンストラクタでミドルウェアを設定しています。
     * 'guest' ミドルウェアは、ログイン済みのユーザーがログインページにアクセスすることを防ぎます。
     * ただし、'logout' アクションは例外として許可されています。
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // ログアウト以外のメソッドはゲストのみアクセス可能
    }

    /**
     * ログイン処理をオーバーライドしてカスタマイズ
     *
     * デフォルトのログイン処理を拡張し、独自のバリデーションや認証ロジックを追加できます。
     * ここでは、Auth::attempt() を使用して手動で認証を行っています。
     *
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

            return redirect()->intended($this->redirectTo); // 指定されたリダイレクト先に遷移
        }

        // 認証失敗時の処理
        return back()->withErrors([
            'username' => 'ユーザー名またはパスワードが正しくありません。', // エラーメッセージを表示
        ]);
    }
}