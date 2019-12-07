@extends('admin.layout.index')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Slide
                        <small>{{$slide->Ten}}</small>
                    </h1>
                </div>
                <div class="col-lg-12">
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
                        <div class="alert alert-warning">
                            {{session('loi')}}
                        </div>
                    @endif
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    <form action="admin/slide/sua/{{$slide->id}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <div class="form-group">
                            <label>Tên Slide</label>
                            <input class="form-control" name="tenslide" placeholder="Vui lòng nhập tên Slide..." value="{{$slide->Ten}}"/>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <img src="upload/slide/{{$slide->Hinh}}" width="200px">
                            <input type="file" name="hinhanh" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input class="form-control" name="link" placeholder="Vui lòng nhập url..."  value="{{$slide->link}}"/>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea class="form-control" rows="3" name="noidung" placeholder="Vui lòng nhập nội dung...">{{$slide->NoiDung}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Cập nhật</button>
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
