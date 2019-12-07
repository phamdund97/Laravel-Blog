<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    //kiểm tra user
    function __construct()
    {
        $this->DangNhap();
    }

    function DangNhap()
    {
        //check đăng nhập với auth check
        if (Auth::check())
        {
            //truyền giá trị vào biến user_login
            view()->share('user_login',Auth::user());
        }
    }
}
