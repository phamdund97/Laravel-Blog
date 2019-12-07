@extends('layout.index')

@section('content')
<!-- Page Content -->
<div class="container">
    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-9">

            <!-- Blog Post -->

            <!-- Title -->
            <h1>{{$tintuc -> TieuDe}}</h1>

            <!-- Author -->
            <p class="lead">
                by <a href="#">Phạm Dự</a>
            </p>

            <!-- Preview Image -->
            <img class="img-responsive" src="upload/tintuc/{{$tintuc->Hinh}}" alt="" style="width: 100%"><br>

            <!-- Date/Time -->
            <p><span class="glyphicon glyphicon-time"></span> Posted on {{$tintuc->created_at}}</p>
            <hr>

            <!-- Post Content -->
            <p class="lead">
{{--                <!-- Dùng {!!  !!} bởi vì trong nội dung chứa thẻ html -->--}}
                {!! $tintuc->NoiDung !!}
            </p>

            <hr>

            <!-- Blog Comments -->

            <!-- Comments Form -->
            @if(isset(\Illuminate\Support\Facades\Auth::user()->id))
            <div class="well">
                <h4>Viết bình luận ...<span class="glyphicon glyphicon-pencil"></span></h4>
                <form role="form" action="comment/{{$tintuc->id}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <textarea class="form-control" rows="3" name="NoiDung"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi</button>
                </form>
            </div>
            @endif

            <hr>

            <!-- Posted Comments -->

            @foreach($tintuc->comment as $cment)
            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{$cment->user->name}}
                        <small>{{$cment->created_at}}</small>
                    </h4>
                    {{$cment->NoiDung}}
                </div>
            </div>
            @endforeach

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-heading"><b>Tin liên quan</b></div>
                <div class="panel-body">

                    @foreach($tinlienquan as $tlq)
                        @if($tintuc-> id != $tlq->id)
                    <!-- item -->
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-5">
                            <a href="tintuc/{{$tlq->id}}/{{$tlq->TieuDeKhongDau}}.html">
                                <img class="img-responsive" src="upload/tintuc/{{$tlq->Hinh}}" alt="" style="width: 100%">
                            </a>
                        </div>
                        <div class="col-md-7">
                            <a href="tintuc/{{$tlq->id}}/{{$tlq->TieuDeKhongDau}}.html"><b>{{$tlq->TieuDe}}</b></a>
                        </div>
                        <div class="break"></div>
                    </div>
                    <!-- end item -->

                        @endif
                    @endforeach

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><b>Tin nổi bật</b></div>
                <div class="panel-body">

                    @foreach($tinnoibat as $tnb)
                    <!-- item -->
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-5">
                            <a>
                                <img class="img-responsive" src="upload/tintuc/{{$tnb->Hinh}}" alt="" style="width: 100%">
                            </a>
                        </div>
                        <div class="col-md-7">
                            <a href="tintuc/{{$tnb->id}}/{{$tnb->TieuDeKhongDau}}.html"><b>{{$tnb->TieuDe}}</b></a>
                        </div>
                        <div class="break"></div>
                    </div>
                    <!-- end item -->
                    @endforeach

                </div>
            </div>

        </div>

    </div>
    <!-- /.row -->
</div>
<!-- end Page Content -->
@endsection
