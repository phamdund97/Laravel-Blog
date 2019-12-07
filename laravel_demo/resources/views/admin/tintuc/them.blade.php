@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin tức
                    <small>Thêm</small>
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
                <form action="admin/tintuc/them" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <!-- enctype="multipart/form-data" giúp upload file -->

                    <div class="form-group">
                        <label>Thể loại liên kết</label>
                        <select class="form-control" name="theloai" id="theloai">
                            <option>Chọn thể loại</option>
                            @foreach($theloai as $theloai1)
                            <option value="{{$theloai1->id}}">{{$theloai1->Ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Loại tin liên kết</label>
                        <select class="form-control" name="loaitin" id="loaitin">
                            <option>Chọn loại tin</option>
                            @foreach($loaitin as $lt)
                                <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input class="form-control" name="tieude" placeholder="Nhập tiêu đề cho tin tức" />
                    </div>
                    <div class="form-group">
                        <label>Tóm tắt</label>
                        <textarea class="form-control ckeditor" rows="3" id="demo" name="tomtat"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea class="form-control ckeditor" rows="8" id="demo" name="noidung"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <input type="file" name="hinhanh" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nổi bật</label>
                        <label class="radio-inline">
                            <input name="noibat" value="0" checked="" type="radio">Không
                        </label>
                        <label class="radio-inline">
                            <input name="noibat" value="1" type="radio">Có
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Thêm mới</button>
                    <button type="reset" class="btn btn-default">Đặt lại</button>
                    </form>
            </div>
        </div>
        <!-- /.row -->
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
