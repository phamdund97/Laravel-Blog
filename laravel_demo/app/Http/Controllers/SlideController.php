<?php

namespace App\Http\Controllers;

use App\LoaiTin;
use App\Slide;
use Illuminate\Http\Request;

use App\TheLoai;
use Illuminate\Support\Str;

class SlideController extends Controller
{
    //Khai báo hàm getDanhSach như trong Route
    public function getDanhsach()
    {
        //Lấy dữ liệu từ model Slide
        $slide = Slide::all();

        //Truyền dữ liệu ra danh sách
        return view('admin.slide.danhsach', ['slide'=>$slide]);
    }

    public function getThem()
    {
        return view('admin.slide.them');
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'tenslide' => 'required | min: 3 | max : 100',
                'hinhanh' => 'required',
                'noidung' => 'required | min: 3 | max: 100',
            ],
            [
                'tenslide.required' => 'Bạn chưa nhập tên slide',
                'tenslide.min' => 'Tên slide yêu cầu tối thiểu 3 kí tự',
                'tenslide.max' => 'Tên slide yêu cầu tối đa 100 kí tự',
                'hinhanh.required' => 'Bạn cần upload ảnh cho slide của bạn',
                'noidung.required' => 'Nội dung slide là yêu cầu',
                'noidung.min' => 'Nội dung slide cần tối thiểu 3 kí tự',
                'noidung.max' => 'Nội dung slide cần tối đa 100 kí tự',
            ]);

        $slide = new Slide;
        $slide->Ten = $request-> tenslide;
        $slide->NoiDung = $request->noidung;
        $slide->link = $request->link;

        //Kiểm tra hình ảnh và gán tên mới
        if($request->hasFile('hinhanh'))
        {
            $file = $request->file('hinhanh');

            $duoianh = $file->getClientOriginalExtension();
            if ($duoianh != 'jpg' && $duoianh != 'png' && $duoianh != 'jpeg')
            {
                return redirect('admin/slide/them')->with('loi','Bạn chỉ được upload file có đuôi là jpg, png, jpeg!');
            }
            $name = $file->getClientOriginalName();

            //đặt tên mới cho hình ảnh với ramdom 4 kí tự + - tên hình
            $tenhinh = Str::random(10)."-".$name;
            while (file_exists("upload/slide/".$tenhinh))
            {
                $tenhinh = Str::random(10)."-".$name;
            }

            //Lưu hình ảnh tới thu mục public/...
            $file->move("upload/slide", $tenhinh);

            //lấy giá trị tên hình truyền vào model = :
            $slide-> Hinh = $tenhinh;

        }
        else
        {
            return redirect('admin/slide/them')->with('thongbao','Slide cần có ảnh để thể hiện!');
        }

        $slide->save();
        return redirect('admin/slide/them')->with('thongbao','Bạn đã thêm Slide thành công!');


    }

    //Nhận về một id
    public function getSua($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide.sua',['slide' => $slide]);
    }

    public function postSua(Request $request,$id)
    {
        $slide = Slide::find($id);
        $this->validate($request,
            [
                'tenslide' => 'required | min: 3 | max : 100',
                'noidung' => 'required | min: 3 | max: 100',
            ],
            [
                'tenslide.required' => 'Bạn chưa nhập tên slide',
                'tenslide.min' => 'Tên slide yêu cầu tối thiểu 3 kí tự',
                'tenslide.max' => 'Tên slide yêu cầu tối đa 100 kí tự',
                'noidung.required' => 'Nội dung slide là yêu cầu',
                'noidung.min' => 'Nội dung slide cần tối thiểu 3 kí tự',
                'noidung.max' => 'Nội dung slide cần tối đa 100 kí tự',
            ]);

        $slide->Ten = $request-> tenslide;
        $slide->NoiDung = $request->noidung;
        $slide->link = $request->link;

        //Kiểm tra hình ảnh và gán tên mới
        if($request->hasFile('hinhanh'))
        {
            $file = $request->file('hinhanh');

            $duoianh = $file->getClientOriginalExtension();
            if ($duoianh != 'jpg' && $duoianh != 'png' && $duoianh != 'jpeg')
            {
                return redirect('admin/slide/sua'.$id)->with('loi','Bạn chỉ được upload file có đuôi là jpg, png, jpeg!');
            }
            $name = $file->getClientOriginalName();

            //đặt tên mới cho hình ảnh với ramdom 4 kí tự + - tên hình
            $tenhinh = Str::random(10)."-".$name;
            while (file_exists("upload/slide/".$tenhinh))
            {
                $tenhinh = Str::random(10)."-".$name;
            }

            //Lưu hình ảnh tới thu mục public/...
            $file->move("upload/slide", $tenhinh);

            //Xóa ảnh cũ
            unlink("upload/slide/".$slide->Hinh);

            //lấy giá trị tên hình truyền vào model = :
            $slide-> Hinh = $tenhinh;

        }

        $slide->save();
        return redirect('admin/slide/sua/'.$id)->with('thongbao','Bạn đã cập nhật Slide thành công!');
    }

    public function getXoa($id)
    {
        $slide = Slide::find($id);
        $slide->delete();

        return redirect('admin/slide/danhsach')->with('thongbao', 'Bạn đã xóa thành công!');
    }
}
