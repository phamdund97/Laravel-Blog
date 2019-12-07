<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Đăng nhâp admin
    public function getdangnhapAdmin()
    {
        return view('admin.login');
    }

    public function postdangnhapAdmin(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required | min: 3 | max: 10',
            ],
            [
                "email.required" => 'Bạn chưa nhập email',
                'password.required' => 'Bạn chưa nhập password',
                'password.min' => 'Mật khẩu tối thiểu 3 kí tự',
                'password.max' => 'Mật khẩu tối đa 10 kí tự',
            ]);

        //Sử dụng lớp auth để đăng nhập
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return redirect('admin/theloai/danhsach');
        }
        else
        {
            return redirect('admin/dangnhap')->with('loi','Đăng nhập thất bại');
        }
    }

    //Logout admin
    public function getLogoutAdmin()
    {
        Auth::logout();
        return redirect('admin/dangnhap');
    }


    //Đăng nhập User
    public function dangnhap()
    {
        return view('pages.dangnhap');
    }

    public function postdangnhapUser(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required | min: 3 | max: 10',
            ],
            [
                "email.required" => 'Bạn chưa nhập email',
                'password.required' => 'Bạn chưa nhập password',
                'password.min' => 'Mật khẩu tối thiểu 3 kí tự',
                'password.max' => 'Mật khẩu tối đa 10 kí tự',
            ]);

        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return redirect('trangchu');
        }
        else
        {
            return redirect('dangnhap')->with('loi','Đăng nhập thất bại');
        }
    }

    public function dangxuat()
    {
        Auth::logout();

        return redirect('trangchu');
    }

    public function dangki()
    {
        return view('pages.dangki');
    }

    public function postDangki(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required | min: 3 | max: 20',
                'email' => 'required | email | unique:users,email',
                'password' => 'required | min: 3 | max:20',
                'passwordAgain' => 'required | same:password',
            ],
            [
                'name.required' => 'Bạn chưa nhập tên của bạn',
                'name.min' => 'Tên cần tối thiểu 3 kí tự',
                'name.max' => 'Tên chỉ được tối đa 20 kí tự',
                'email.required' => 'Bạn chưa nhập email',
                'email.unique' => 'Email này đã có người dùng',
                'email.email' => 'Vui lòng nhập đúng dạng email',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu cần tối thiểu 3 kí tự',
                'password.max' => 'Mật khẩu chỉ được tối đa 20 kí tự',
                'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same' => 'Mật khẩu không trùng khớp',
            ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->quyen = 0;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('dangki')->with('thongbao','Bạn đã đăng kí thành công!');
    }
}
