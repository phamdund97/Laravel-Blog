<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    //
    protected $table = "TheLoai";

    public function loaitin()
    {
        return $this->hasMany('App\LoaiTin','idTheLoai','id');
    }

    //đếm số lượng tin tức trong thể loại thông qua bảng tin tức và loại tin
    public function tintuc()
    {
        return $this->hasManyThrough('App\TinTuc','App\LoaiTin', 'idTheLoai','idLoaiTin','id');
    }
}
