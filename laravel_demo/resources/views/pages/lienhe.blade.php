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
                    <h2 style="margin-top:0px; margin-bottom:0px;">Liên hệ</h2>
                </div>

                <div class="panel-body">
                    <!-- item -->
                    <h3><span class="glyphicon glyphicon-align-left"></span> Thông tin liên hệ</h3>

                    <div class="break"></div>
                    <h4><span class= "glyphicon glyphicon-home "></span> Địa chỉ : </h4>
                    <p>Ngõ 68 Triều khúc - Thanh Trì - Hà Nội</p>

                    <h4><span class="glyphicon glyphicon-envelope"></span> Email : </h4>
                    <p>Phamdund97@gmail.com</p>

                    <h4><span class="glyphicon glyphicon-phone-alt"></span> Điện thoại : </h4>
                    <p>No telephone here!</p>



                    <br><br>
                    <h3><span class="glyphicon glyphicon-globe"></span> Bản đồ</h3>
                    <div class="break"></div><br>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14901.08252280073!2d105.79202047116314!3d20.98178611139698!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135acc3ae37fc47%3A0x607ded9d4d1d1182!2zVHJp4buBdSBLaMO6YywgVMOibiBUcmnhu4F1LCBUaGFuaCBUcsOsLCBIw6AgTuG7mWksIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1575563695918!5m2!1svi!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- end Page Content -->
@endsection
