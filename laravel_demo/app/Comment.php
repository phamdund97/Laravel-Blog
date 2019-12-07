<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //Khai báo tên bảng database
    protected $table = "Comment";

    //muốn biết comment thuộc tin tức nào
    public function tintuc()
    {
        return $this->belongsTo('App\TinTuc','idTinTuc','id');
    }

    //muốn biết comment thuộc user nào
    public function user()
    {
        return $this->belongsTo('App\User','idUser','id');
    }
}
