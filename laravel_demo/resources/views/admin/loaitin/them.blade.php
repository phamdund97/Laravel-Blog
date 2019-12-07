@extends('admin.layout.index')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Loại Tin
                        <small>Thêm </small>
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

                    <form method="POST" action="admin/loaitin/them">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <div class="form-group">
                            <label>Tên của thể loại</label>
                            <input class="form-control" name="txtCateName" placeholder="Nhập tên của loại tin" />
                        </div>
                        <div class="form-group">
                            <label>Thể loại</label>
                            <select name="idtheloai" class="form-control">
                                @foreach($tentheloai as $name)
                                <option value="{{$name->id}}">{{$name->Ten}}</option>
                                @endforeach
                            </select>
{{--                            <input class="form-control" name="idtheloai" placeholder="Nhập ID thể loại liên kết..." />--}}
                        </div>
                        <button type="submit" class="btn btn-default">Thêm loại tin</button>
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
