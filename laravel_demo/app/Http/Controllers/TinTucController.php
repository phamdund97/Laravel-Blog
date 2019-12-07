<?php

namespace App\Http\Controllers;

use App\Comment;
use App\LoaiTin;
use App\TinTuc;
use Illuminate\Http\Request;

use App\TheLoai;
use Illuminate\Support\Str;

class TinTucController extends Controller
{
    //Khai báo hàm getDanhSach như trong Route
    public function getDanhsach()
    {
        //danh sách tin tức với tin cuối cùng về đầu tiên
        //tức tin mới nhất đến tin cũ nhất với id và giảm dần DESC
        $tintuc = TinTuc::orderBy('id','DESC')->get();
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them',['theloai' => $theloai],['loaitin' => $loaitin]);
    }

    //Tạo hàm nhận dữ liệu từ post -> Route về
    //Hàm request để nhận dữ liệu từ post
    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'loaitin' => 'required',
                'tieude' => 'required | min: 3 ',
                'tomtat' =>'required',
                'noidung' => 'required',
            ],
            [
                'loaitin.required' => 'Bạn chưa chọn loại tin',
                'tieude.required' => 'Bạn chưa điều tiêu đề',
                'tieude.min' => 'Tiêu đề phải có ít nhất 3 kí tự',
                'tomtat.required' => 'Bạn chưa nhập tóm tắt',
                'noidung.required' => 'Bạn chưa nhập nội dung',
            ]);

        $tintuc = new TinTuc;
        $tintuc-> TieuDe = $request-> tieude;
        $tintuc->TieuDeKhongDau = changeTitle($request->tieude);
        $tintuc->idLoaiTin = $request->loaitin;
        $tintuc->TomTat = $request-> tomtat;
        $tintuc->NoiDung = $request-> noidung;
        $tintuc->SoLuotXem = 0;
        $tintuc->NoiBat = $request->noibat;

        //Kiểm tra hình ảnh upload
        if ($request->hasFile('hinhanh'))
        {
            $file = $request->file('hinhanh');

            //lấy đuôi của ảnh upload
            $duoianh = $file->getClientOriginalExtension();
            if ($duoianh != 'jpg' && $duoianh != 'png' && $duoianh != 'jpeg')
            {
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được upload file có đuôi là jpg, png, jpeg!');
            }
            //lấy tên hình ảnh
            $name = $file->getClientOriginalName();

            //đặt tên mới cho hình ảnh với ramdom 4 kí tự + - tên hình
            $tenhinh = Str::random(10)."-".$name;
            //kiểm tra file chứa tên có tồn tại hay chưa, nếu fileexists kiểm tra
            //tên file đã tồn tại trả về true và vòng lặp sẽ lặp tên mới cho đến khi có tên mới không bị trùng
            while (file_exists("upload/tintuc/".$tenhinh))
            {
                $tenhinh = Str::random(10)."-".$name;
            }

            //Lưu hình ảnh tới thu mục public/...
            $file->move("upload/tintuc", $tenhinh);

            //lấy giá trị tên hình truyền vào model = :
            $tintuc-> Hinh = $tenhinh;
        }
        else
        {
            $tintuc->Hinh = '';
        }

        //Lưu vào model
        $tintuc->save();

        //trả về trang thêm và thông báo thành công
        return redirect('admin/tintuc/them')->with('thongbao','Bạn đã thêm tin tức mới thành công');
    }

    //Nhận về một id
    public function getSua($id)
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);
        return view('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    public function postSua(Request $request,$id)
    {
        $tintuc = TinTuc::find($id);
        $this->validate($request,
            [
                'loaitin' => 'required',
                'tieude' => 'required | min: 3 ',
                'tomtat' =>'required',
                'noidung' => 'required',
            ],
            [
                'loaitin.required' => 'Bạn chưa chọn loại tin',
                'tieude.required' => 'Bạn chưa điều tiêu đề',
                'tieude.min' => 'Tiêu đề phải có ít nhất 3 kí tự',
                'tomtat.required' => 'Bạn chưa nhập tóm tắt',
                'noidung.required' => 'Bạn chưa nhập nội dung',
            ]);

        $tintuc-> TieuDe = $request-> tieude;
        $tintuc->TieuDeKhongDau = changeTitle($request->tieude);
        $tintuc->idLoaiTin = $request->loaitin;
        $tintuc->TomTat = $request-> tomtat;
        $tintuc->NoiDung = $request-> noidung;
        $tintuc->SoLuotXem = 0;
        $tintuc->NoiBat = $request->noibat;

        //Kiểm tra hình ảnh upload
        if ($request->hasFile('hinhanh'))
        {
            $file = $request->file('hinhanh');

            //lấy đuôi của ảnh upload
            $duoianh = $file->getClientOriginalExtension();
            if ($duoianh != 'jpg' && $duoianh != 'png' && $duoianh != 'jpeg')
            {
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được upload file có đuôi là jpg, png, jpeg!');
            }
            //lấy tên hình ảnh
            $name = $file->getClientOriginalName();

            //đặt tên mới cho hình ảnh với ramdom 4 kí tự + - tên hình
            $tenhinh = Str::random(10)."-".$name;
            //kiểm tra file chứa tên có tồn tại hay chưa, nếu fileexists kiểm tra
            //tên file đã tồn tại trả về true và vòng lặp sẽ lặp tên mới cho đến khi có tên mới không bị trùng
            while (file_exists("upload/tintuc/".$tenhinh))
            {
                $tenhinh = Str::random(10)."-".$name;
            }

            //Lưu hình ảnh tới thu mục public/...
            $file->move("upload/tintuc", $tenhinh);

            //Xóa hình ảnh cũ
            unlink("upload/TinTuc/".$tintuc->Hinh);

            //lấy giá trị tên hình truyền vào model = :
            $tintuc-> Hinh = $tenhinh;
        }

        //Lưu vào model
        $tintuc->save();

        //trả về trang thêm và thông báo thành công
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Bạn đã sửa tin tức thành công');

    }

    public function getXoa($id)
    {
        $tintuc = TinTuc::find($id);
        $tintuc->delete();

        return redirect('admin/tintuc/danhsach')->with('thongbao', 'Bạn đã xóa tin tức thành công!');
    }

    public  function getXoaComment($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect('admin/tintuc/sua/'.$comment->idTinTuc)->with('thongbaocomment','Bạn đã xóa thành công comment: '.' '.$comment->NoiDung);
    }
}
