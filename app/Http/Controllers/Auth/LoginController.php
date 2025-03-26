<?php

// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * ログイン後のリダイレクト先を指定
     *
     * @var string
     */
    protected $redirectTo = '/dashboard'; // ログイン後に遷移するパスを /dashboard に変更

    /**
     * 認証に使用するカラムを指定（デフォルトは'email'）
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
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // ログアウト以外のメソッドはゲストのみアクセス可能
    }
}