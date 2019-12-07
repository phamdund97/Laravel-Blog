<?php

namespace App\Http\Controllers;

use App\LoaiTin;

class AjaxController extends Controller
{
    //nhận dữ liệu từ ajax html
    public function getLoaiTin($idtheloai){
        //tìm loại tin theo thể loại lấy từ ajax Route về
        $loaitin = LoaiTin::where('idtheloai',$idtheloai)->get();

        //Vòng lặp giúp in tất cả loại tin theo id thể loại lấy về
        foreach ($loaitin as $lt)
        {
            echo "<option value='".$lt->id."'>".$lt->Ten."</option>";
        }
    }
}
