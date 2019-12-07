<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TheLoai;

class TheLoaiController extends Controller
{
    //Khai báo hàm getDanhSach như trong Route
    public function getDanhsach()
    {
        //Lưu danh sách thể loại lấy được từ model với lấy tất cả bằng hàm all():
        $theloai = TheLoai::all();

        //truyền dữ liệu sang trang admin/theloai/danhsach với mảng có key tên biến muốn truyền sang là theloai
        //tên biến muốn truyền lấy dữ liệu từ biến $theloai khai bao bên trên
        return view('admin.theloai.danhsach', ['theloai'=>$theloai]);
    }

    public function getThem()
    {
        return view('admin.theloai.them');
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
                'txtCateName' => 'required | min: 2 | max: 100 | unique:TheLoai,Ten'
            ],
            [
                //Truyền thông báo lỗi sau khi kiểm tra điều kiện không thỏa mãn
                'txtCateName.require' => 'Bạn chưa nhập tên thể loại',
                'txtCateName.min' => 'Tên thể loại cần tối thiểu 2 kí tự',
                'txtCateName.max' => 'Tên thể loại tối đa 100 kí tự',
                'Tentheloai.unique' => 'Tên đã tồn tại',
            ]);
            //Sau khi bắt lỗi xong thì lấy dữ liệu lưu vào model
        $theloai = new TheLoai;
        $theloai->Ten = $request->txtCateName;
        $theloai->TenKhongDau = changeTitle($request->txtCateName);
        //check đổi tên không dấu
        //echo changeTitle($request->txtCateName);

        //Lưu dữ liệu vào database
        $theloai->save();
        return redirect('admin/theloai/them')->with('thongbao','Thêm thành công!');
    }

    //Nhận về một id
    public function getSua($id)
    {
        //Tìm thể loại có id cần truyền vào
        //Biến thể loại = model thể loại với hàm find() để tìm id ở trên
        $theloai = TheLoai::find($id);
        //Chuyển id sang trang sửa để sửa
        return view('admin.theloai.sua', ['theloai' => $theloai]);
    }

    public function postSua(Request $request,$id)
    {
        //Lấy thể loại muốn sửa
        $theloai = TheLoai::find($id);
        //Kiểm tra trong đó unique là kiểm tra tên nhập vào có bị trùng trong model không
        //Nếu trùng thì trùng ở bảng nào: TheLoai hoặc cột nào: Ten
        $this->validate($request,
            [
                'Tentheloai' => 'required | min: 3 | max: 100'
            ],
            [
                'Tentheloai.required' => 'Bạn chưa nhập tên thể loại',
                'Tentheloai.min' => 'Tên thể loại phải trong khoảng 3 - 100 kí tự',
                'Tentheloai.max' => 'Tên thể loại chỉ được tối đa 10 kí tự',
            ]);

        //Sửa tên thể loại trong model

        $theloai->Ten = $request->Tentheloai;
        $theloai->TenKhongDau = changeTitle($request->Tentheloai);
        $theloai->save();

        //đưa người dùng về trang sửa và thông báo
        return redirect('admin/theloai/sua/'.$id)->with('thongbao2','Sửa thành công!');
    }

    public function getXoa($id)
    {
        $theloai = TheLoai::find($id);
        $theloai->delete();

        return redirect('admin/theloai/danhsach')->with('thongbao3', 'Xóa thành công thể loại!');
    }
}
