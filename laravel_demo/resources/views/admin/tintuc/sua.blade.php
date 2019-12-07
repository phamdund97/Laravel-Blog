@extends('admin.layout.index')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tin tức
                        <small>{{$tintuc->TieuDe}}</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">

                    {{--                Hiển thị báo lỗi trước tiên--}}
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                                {{$err}}<br>
                            @endforeach
                        </div>
                    @endif

                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif

                    @if(session('loi'))
                        <div class="alert alert-danger">
                            {{session('loi')}}
                        </div>
                    @endif
                    <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <!-- enctype="multipart/form-data" giúp upload file -->

                        <div class="form-group">
                            <label>Thể loại liên kết</label>
                            <select class="form-control" name="theloai" id="theloai">
                                <option>Chọn thể loại</option>
                                @foreach($theloai as $theloai1)
                                    <option
                                        @if($tintuc->loaitin->theloai->id == $theloai1->id)
                                            {{"selected"}}
                                        @endif
                                        value="{{$theloai1->id}}">{{$theloai1->Ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Loại tin liên kết</label>
                            <select class="form-control" name="loaitin" id="loaitin">
                                <option>Chọn loại tin</option>
                                @foreach($loaitin as $lt)
                                    <option
                                        @if($tintuc->loaitin->id == $lt->id)
                                        {{"selected"}}
                                        @endif
                                        value="{{$lt->id}}">{{$lt->Ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input class="form-control" name="tieude" placeholder="Nhập tiêu đề cho tin tức" value="{{$tintuc->TieuDe}}"/>
                        </div>
                        <div class="form-group">
                            <label>Tóm tắt</label>
                            <textarea class="form-control ckeditor" rows="3" id="demo" name="tomtat">{{$tintuc->TomTat}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea class="form-control ckeditor" rows="8" id="demo" name="noidung">{{$tintuc->NoiDung}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <img src="upload/tintuc/{{$tintuc->Hinh}}" width="400px"><br>
                            <input type="file" name="hinhanh" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nổi bật</label>
                            <label class="radio-inline">
                                <input name="noibat" value="0" @if($tintuc->NoiBat == 0) {{"checked"}} @endif type="radio">Không
                            </label>
                            <label class="radio-inline">
                                <input name="noibat" value="1" type="radio" @if($tintuc->NoiBat == 1) {{"checked"}} @endif>Có
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Cập nhật</button>
                        <button type="reset" class="btn btn-default">Đặt lại</button>
                    </form>
                </div>
            </div>
            <!-- /.row -->
            <!--row comment -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Comment
                        <small>{{$tintuc->TieuDe}}</small>
                    </h1>
                </div>
                <div class="col-lg-12">
                    @if(session('thongbaocomment'))
                        <div class="alert alert-success">
                            {{session('thongbaocomment')}}
                        </div>
                    @endif
                </div>
                <!-- /.col-lg-12 -->
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>User</th>
                        <th>Nội dung</th>
                        <th>Ngày đăng</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--                Dùng vòng lặp để hiển thị sanh sách thể loại--}}
                    {{--                biến thể loại được láy từ TheLoaiController--}}
                    @foreach($tintuc->comment as $cm)
                        <tr class="odd gradeX" align="center">
                            <td>{{$cm->id}}</td>
                            <td>{{$cm->user->name}}</td>
                            <td>{{$cm->NoiDung}}</td>
                            <td>{{$cm->created_at}}</td>
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{$cm->id}}"> Delete</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- end row comment -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $("#theloai").change(function () {
                //lấy id thể loại và truyền vào biến idtheloai từ id thẻ select là #theloai
                var idtheloai = $(this).val();
                //gọi trang ajax truyền dữ liệu idtheloai đến Route trong group admin với group route là ajax
                //function(data) giúp nhận dữ liệu trả về từ AjaxController
                $.get('admin/ajax/loaitin/' + idtheloai, function (data) {
                    //hiển thị dữ liệu data ra thẻ select loại tin
                    $("#loaitin").html(data);
                });
            })
        })
    </script>
@endsection
