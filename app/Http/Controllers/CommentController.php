<?php

namespace App\Http\Controllers;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getComment($id){
        $comment = Comment::where('product_id',$id)->where('reply_id',0)->latest()->simplePaginate(5);
        return response()->json($comment,200);
    }
}
