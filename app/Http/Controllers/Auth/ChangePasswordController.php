<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    /**
     * パスワード変更フォームを表示
     */
    public function showChangePasswordForm()
    {
        return view('auth.passwords.change'); // ビューを指定
    }

    /**
     * 新しいパスワードを保存
     * 
     */
    public function updatePassword(Request $request)
{
    // Validate the input
    $request->validate([
        'username' => ['required', 'string'], // Username is required
        'new_password' => ['required', 'string', 'min:8', 'confirmed'], // New password validation
    ]);

    // Find the user by username
    $user = \App\Models\User::where('username', $request->input('username'))->first();

    // If the user does not exist, return an error
    if (!$user) {
        return back()->withErrors(['username' => 'The specified username does not exist.']);
    }

    // Update the user's password
    $user->update([
        'password' => Hash::make($request->input('new_password')),
    ]);

    // Redirect with a success message
    return redirect()->route('login')->with('success', 'Your password has been updated.');
}
}