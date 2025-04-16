<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'consecutive_days' => 0,
            'level' => 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // ✅ バリデーション（画像 + ユーザー名の重複チェック）
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'], // ← 追加！
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // ✅ プロフィール画像の保存処理
        $profilePhotoUrl = null;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $path = $file->store('public/profile_icons');
            $profilePhotoUrl = Storage::url($path);
        }

        // ✅ ユーザー登録処理
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'profile_photo_url' => $profilePhotoUrl,
            'consecutive_days' => 0,
            'level' => 1,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
