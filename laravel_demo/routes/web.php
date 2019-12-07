<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\TheLoai;

Route::get('/', function () {
    return view('welcome');
});

Route::get('Testconnection', function () {
    $theloai = TheLoai::find(1);
    foreach ($theloai->Loaitin as $loaitin){
        echo $loaitin->Ten." + ".$loaitin->TenKhongDau."<br>";
    }
});

//ROute đăng nhập admin
Route::get('admin/dangnhap','UserController@getdangnhapAdmin');
Route::post('admin/dangnhap','UserController@postdangnhapAdmin');

//Route logout
Route::get('admin/logout','UserController@getLogoutAdmin');

Route::group(['prefix'=>'admin', 'middleware'=>'adminlogin'],function (){
    Route::group(['prefix'=>'theloai'],function (){
       // admin/theloai/danhsach
        Route::get('danhsach','TheLoaiController@getDanhSach');

        Route::get('sua/{id}','TheLoaiController@getSua');
        Route::post('sua/{id}','TheLoaiController@postSua');

        Route::get('them','TheLoaiController@getThem');

        Route::post('them','TheLoaiController@postThem');

        Route::get('xoa/{id}', 'TheLoaiController@getXoa');
    });

    Route::group(['prefix'=>'loaitin'],function (){
        // admin/loaitin/danhsach
        Route::get('danhsach','LoaiTinController@getDanhSach');

        Route::get('sua/{id}','LoaiTinController@getSua');
        Route::post('sua/{id}','LoaiTinController@postSua');

        Route::get('them','LoaiTinController@getThem');

        Route::post('them','LoaiTinController@postThem');

        Route::get('xoa/{id}', 'LoaiTinController@getXoa');
    });

    Route::group(['prefix'=>'tintuc'],function (){
        // admin/tintuc/danhsach
        Route::get('danhsach','TinTucController@getDanhSach');

        Route::get('sua/{id}','TinTucController@getSua');
        Route::post('sua/{id}','TinTucController@postSua');

        Route::get('them','TinTucController@getThem');
        Route::post('them','TinTucController@postThem');

        Route::get('xoa/{id}', 'TinTucController@getXoa');


    });

    Route::group(['prefix'=>'comment'],function (){
        Route::get('xoa/{id}','TinTucController@getXoaComment');
    });

    Route::group(['prefix'=>'slide'],function (){
        // admin/theloai/danhsach
        Route::get('danhsach','SlideController@getDanhSach');

        Route::get('sua/{id}','SlideController@getSua');
        Route::post('sua/{id}','SlideController@postSua');

        Route::get('them','SlideController@getThem');
        Route::post('them', 'SlideController@postThem');

        Route::get('xoa/{id}', 'SlideController@getXoa');
    });

    Route::group(['prefix'=>'user'],function (){
        // admin/theloai/danhsach
        Route::get('danhsach','TheLoaiController@getDanhSach');


        Route::get('sua','TheLoaiController@getSua');

        Route::get('them','TheLoaiController@getThem');
    });

    //Route nhận ajax
    Route::group(['prefix' => 'ajax'],function (){
       Route::get('loaitin/{idtheloai}','AjaxController@getLoaiTin');
//       Route::get('')
    });
});


//Route cho user
Route::get('trangchu','PageController@trangchu');
Route::get('lienhe','PageController@lienhe');
Route::get('loaitin/{id}/{TenKhongDau}.html','PageController@loaitin');
Route::get('tintuc/{id}/{TieuDeKhongDau}.html','PageController@tintuc');

//đăng nhập user
Route::get('dangnhap','UserController@dangnhap');
Route::post('dangnhap','UserController@postdangnhapUser');
Route::get('dangxuat','UserController@dangxuat');

Route::get('dangki','UserController@dangki');
Route::post('dangki','UserController@postDangki');

//Tìm kiếm
//Route::post('timkiem','PageController@timkiem');
Route::match(['get', 'post'], 'timkiem','PageController@timkiem');

//quản lí người dùng
Route::group(['prefix'=>'user', 'middleware'=>'userlogin'],function () {
    Route::get('nguoidung', 'PageController@getUser');
    Route::post('nguoidung', 'PageController@postUser');
});

Route::post('comment/{id}','CommentController@postComment');
