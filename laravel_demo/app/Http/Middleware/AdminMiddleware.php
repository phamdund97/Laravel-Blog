<?php

namespace App\Http\Middleware;

use Closure;
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
    public function handle($request, Closure $next)
    {
        //kiểm tra người dùng có đang đăng nhập hay không
        if (Auth::check())
        {
            //kiểm tra quyền của user
            $user = Auth::user();
            if ($user->quyen == 1)
            {
                return $next($request);
            }
            else
            {
                return redirect('admin/dangnhap');
            }
        }
        else
        {
            return redirect('admin/dangnhap');
        }
    }
}
