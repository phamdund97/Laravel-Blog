<?php

namespace App\Http\Controllers;

use App\Comment;
use App\TinTuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function postComment(Request $request,$id)
    {
        $tintuc = TinTuc::find($id);
        $comment = new Comment;
        $comment->idTinTuc = $id;
        $comment->idUser = Auth::user()->id;
        $comment->NoiDung = $request->NoiDung;
        $comment->save();

        return redirect('tintuc/'.$id."/".$tintuc->TieuDeKhongDau.".html");
    }
}
