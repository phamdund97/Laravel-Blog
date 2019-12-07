@extends('layout.index')

@section('content')
<!-- Page Content -->
<div class="container">

    <!-- slider -->
    @include('layout.slide')
    <!-- end slide -->

    <div class="space20"></div>


    <div class="row main-left">
        @include('layout.menu')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#337AB7; color:white;" >
                    <h2 style="margin-top:0px; margin-bottom:0px;">Tin Tức Chung</h2>
                </div>

                <div class="panel-body">
                    @foreach($theloai as $tloai)
                        @if( count($tloai->loaitin) > 0)
                    <!-- item -->
                    <div class="row-item row">
                        <h3>
                            <a href="category.html">{{$tloai->Ten}}</a> |
                            @foreach($tloai->loaitin as $ltin)
                            <small><a href="loaitin/{{$ltin->id}}/{{$ltin->TenKhongDau}}.html"><i>{{$ltin->Ten}}</i></a>/</small>
                            @endforeach
                        </h3>

                        <?php
                        $data = $tloai->tintuc->where('NoiBat', 1)->sortByDesc('created_at')->take(5);
                        //lấy một tin từ data ra, từ đó data chỉ còn 4 tin.
                        $tinf = $data->shift();
                        ?>
                            @if(!empty($tinf) > 0)
                        <div class="col-md-8 border-right">
                            <div class="col-md-5">
                                <a href="tintuc/{{$tinf['id']}}/{{$tinf['TieuDeKhongDau']}}.html">
                                    <img class="img-responsive" src="upload/tintuc/{{$tinf['Hinh']}}" alt="" style="width: 100%">
                                </a>
                            </div>

                            <div class="col-md-7">
                                <h3>{{$tinf['TieuDe']}}</h3>
                                <p>{!! $tinf['TomTat'] !!}</p>
                                <a class="btn btn-primary" href="tintuc/{{$tinf['id']}}/{{$tinf['TieuDeKhongDau']}}.html">Xem Thêm <span class="glyphicon glyphicon-chevron-right"></span></a>
                            </div>
                        </div>
                            @endif

                        <div class="col-md-4">
                            @foreach($data as $dt)
                            <a href="tintuc/{{$dt['id']}}/{{$dt['TieuDeKhongDau']}}.html">
                                <h4>
                                    <span class="glyphicon glyphicon-list-alt" style="color:#0A568C"></span>
                                    {{$dt['TieuDe']}}
                                </h4>
                            </a>
                            @endforeach
                        </div>

                        <div class="break"></div>
                    </div>
                    <!-- end item -->
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- end Page Content -->
@endsection
