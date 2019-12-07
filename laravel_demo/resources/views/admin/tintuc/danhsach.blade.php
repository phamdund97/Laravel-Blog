@extends('admin.layout.index')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tin Tức
                        <small>Danh sách</small>
                    </h1>
                </div>
                <div class="col-lg-12">
                    @if(session('thongbaodanhsach'))
                        <div class="alert alert-success">
                            {{session('thongbaodanhsach')}}
                        </div>
                    @endif
                </div>
                <div class="col-lg-12">
                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif
                </div>
                <!-- /.col-lg-12 -->
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Tóm tắt</th>
                        <th>Thể loại</th>
                        <th>Loại tin</th>
                        <th>Lượt xem</th>
                        <th>Nổi bật</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--                Dùng vòng lặp để hiển thị sanh sách thể loại--}}
                    {{--                biến thể loại được láy từ TheLoaiController--}}
                    @foreach($tintuc as $tt)
                        <tr class="odd gradeX" align="center">
                            <td>{{$tt->id}}</td>
                            <td>{{$tt->TieuDe}}
                                <div class="form-avatar">
                                    <img src="upload/tintuc/{{$tt->Hinh}}" width="100px">
                                </div>
                            </td>
                            <td>{{$tt->TomTat}}</td>

                            {{--Trỏ từ tin tức lấy loại tin bằng idLoaiTin sau đó trỏ về loại tin
                            lấy idTheLoai và lấy tên thể loại từ Thể loại--}}

                            <td>{{$tt->loaitin->theloai->Ten}}</td>
                            <td>{{$tt->loaitin->Ten}}</td>
                            <td>{{$tt->SoLuotXem}}</td>
                            <td>
                                @if($tt->NoiBat == 0)
                                    {{"Không"}}
                                @else{{'Có'}}
                                @endif
                            </td>
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/tintuc/xoa/{{$tt->id}}"> Delete</a></td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/tintuc/sua/{{$tt->id}}">Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection
