<?php

namespace App\Http\Controllers;

use App\LoaiTin;
use Illuminate\Http\Request;

use App\TheLoai;

class LoaiTinController extends Controller
{
    //Khai báo hàm getDanhSach như trong Route
    public function getDanhsach()
    {
        //Lưu danh sách loại tin lấy được từ model với lấy tất cả bằng hàm all():
        $loaitin = LoaiTin::all();

        //truyền dữ liệu sang trang admin/theloai/danhsach với mảng có key tên biến muốn truyền sang là theloai
        //tên biến muốn truyền lấy dữ liệu từ biến $theloai khai bao bên trên
        return view('admin.loaitin.danhsach', ['loaitin'=>$loaitin]);
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
        return view('admin.loaitin.them',['tentheloai' => $theloai]);
    }

    //Tạo hàm nhận dữ liệu từ post -> Route về
    //Hàm request để nhận dữ liệu từ post
    public function postThem(Request $request)
    {
        // biến nhập name = txtCateName;

        //Check dữ liệu có được nhập vào form hay chưa
        //dùng hàm validate để check điều kiện
        $this->validate($request,
            [
                //kiểm tra form nhập: là yêu cầu, min: tối thiểu là 2 kí tự, max: 100 kí tự
                'txtCateName' => 'required | min: 2 | max: 100 ',
                'idtheloai' => ' required'
            ],
            [
                //Truyền thông báo lỗi sau khi kiểm tra điều kiện không thỏa mãn
                'txtCateName.required' => 'Bạn chưa nhập tên loại tin',
                'txtCateName.min' => 'Tên loại tin cần tối thiểu 2 kí tự',
                'txtCateName.max' => 'Tên loại tin tối đa 100 kí tự',
                'idtheloai.required' => ' Bạn chưa nhập ID thể loại liên kết',
            ]);
        //Sau khi bắt lỗi xong thì lấy dữ liệu lưu vào model
        $loaitin = new LoaiTin;
        $loaitin->Ten = $request->txtCateName;
        $loaitin->TenKhongDau = changeTitle($request->txtCateName);
        $loaitin->idTheLoai = $request->idtheloai;
        //check đổi tên không dấu
        //echo changeTitle($request->txtCateName);

        //Lưu dữ liệu vào database
        $loaitin->save();
        return redirect('admin/loaitin/them')->with('thongbao','Thêm thành công!');
    }

    //Nhận về một id
    public function getSua($id)
    {
        //Tìm thể loại có id cần truyền vào
        //Biến thể loại = model thể loại với hàm find() để tìm id ở trên
        $loaitin = LoaiTin::find($id);
        //Chuyển id sang trang sửa để sửa
        return view('admin.loaitin.sua', ['loaitin' => $loaitin]);
    }

    public function postSua(Request $request,$id)
    {
        //Lấy thể loại muốn sửa
        $loaitin = LoaiTin::find($id);
        //Kiểm tra trong đó unique là kiểm tra tên nhập vào có bị trùng trong model không
        //Nếu trùng thì trùng ở bảng nào: TheLoai hoặc cột nào: Ten
        $this->validate($request,
            [
                'Tenloaitin' => 'required | min: 3 | max: 100'
            ],
            [
                'Tenloaitin.required' => 'Bạn chưa nhập tên thể loại',
                'Tenloaitin.min' => 'Tên thể loại phải trong khoảng 3 - 100 kí tự',
                'Tenloaitin.max' => 'Tên thể loại chỉ được tối đa 10 kí tự',
            ]);

        //Sửa tên thể loại trong model

        $loaitin->Ten = $request->Tenloaitin;
        $loaitin->TenKhongDau = changeTitle($request->Tenloaitin);
        $loaitin->save();

        //đưa người dùng về trang sửa và thông báo
        return redirect('admin/loaitin/sua/'.$id)->with('thongbao2','Sửa thành công!');
    }

    public function getXoa($id)
    {
        $loaitin = LoaiTin::find($id);
        $loaitin->delete();

        return redirect('admin/loaitin/danhsach')->with('thongbao3', 'Xóa thành công thể loại!');
    }
}
