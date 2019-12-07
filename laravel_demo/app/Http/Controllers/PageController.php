<?php

namespace App\Http\Controllers;

use App\LoaiTin;
use App\Slide;
use App\TheLoai;
use App\TinTuc;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    //Xây dựng view share chia sẻ biến thể loại cho tất cả function
    public function __construct()
    {
        $theloai = TheLoai::all();
        $slide = Slide::orderBy('id','ASC')
            ->skip(0)
            ->take(4)
            ->get();
        view()->share('theloai',$theloai);
        view()->share('slide',$slide);

        //Kiểm tra người dùng đăng nhập hay chưa
//        if (Auth::check())
//        {
//            view()->share('nguoidung',Auth::user());
//        }
//        else
//        {
//
//        }
    }

    function trangchu()
    {
//        $theloai = TheLoai::all();
        return view('pages.trangchu');
    }

    public function lienhe()
    {
        return view('pages.lienhe');
    }

    public function loaitin($id)
    {
        $loaitin = LoaiTin::find($id);
        //lấy loại tin và dùng phân trang paginate lấy 5 giá trị cho 1 trang
        $tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }

    public function tintuc($id)
    {
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(10)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc' => $tintuc, 'tinnoibat' => $tinnoibat, 'tinlienquan' => $tinlienquan]);
    }

    public function getUser()
    {
        $nguoidung = Auth::user();
        return view('pages.nguoidung',['nguoidung' => $nguoidung]);
    }

    public function postUser(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required | min: 2 | max: 30',
            ],
            [
                'name.required' => 'Bạn cần nhập tên của bạn',
                'name.min' => 'Xin lỗi! Tên cần tối thiểu 2 kí tự',
                'name.max' => 'Xin lỗi! Tên chỉ được tối đa 30 kí tự',
            ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->quyen = 0;

        //check user change pass
        if ($request->checkpassword == "on")
        {
            $this->validate($request,
                [
                    'password' => 'required | min: 3 | max: 20',
                    'passwordAgain' => 'required | same:password',
                ],
                [
                    'password.required' => 'Bạn cần nhập mật khẩu mới của bạn',
                    'password.min' => 'Mật khẩu mới cần tối  thiểu 3 kí tự',
                    'password.max' => 'Mật khẩu mới chỉ được tối đa 20 kí tự',
                    'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu mới của bạn',
                    'passwordAgain.same' => 'Mật khẩu nhập lại của bạn chưa trùng khớp',
                ]);
            $user ->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('user/nguoidung')->with('thongbao','Bạn đã cập nhật thông tin thành công!');
    }

    //Tìm kiếm theo từ khóa
    public function timkiem(Request $request)
    {
        $tukhoa = $request->timkiem;
        //Sử dụng toán tử so sánh Like
        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orwhere('TomTat','like',"%$tukhoa%")
            ->orwhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(5);

        return view('pages.timkiem',['tintuc'=>$tintuc,'tukhoa' => $tukhoa]);
    }

    public function gettimkiem()
    {
        return timkiem();
    }
}
