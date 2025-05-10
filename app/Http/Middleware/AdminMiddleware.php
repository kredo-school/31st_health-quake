<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // ユーザーが認証されていて、かつロールが「Admin」の場合のみ許可
        if (Auth::check() && Auth::user()->role === 'Admin') {
            return $next($request);
        }

        // 許可されていない場合はリダイレクト
        return redirect('/')->with('error', 'You do not have permission to access this page.');
    }
}