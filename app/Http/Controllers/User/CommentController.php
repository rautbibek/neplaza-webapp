<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Notifications\CommentNotification;
use App\Http\Requests\CommentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class CommentController extends Controller
{

    public function post(CommentRequest $request){

        $product= Product::where('id',$request->product_id)->first();
        $comment = new Comment;
        $comment->product_id = $request->product_id;
        $comment->user_id = Auth::id();
        $comment->body = $request->comment;
        $comment->save();
        //applying notification
        if(Auth::id() != $product->user_id){
            $collect = collect(['id'=>$product->id,'cover'=>Auth::user()->cover,'user'=>Auth::user()->name,'slug'=>$product->slug,'productid'=>$product->id,'message'=>"Commentd on your ad"]);
            $product->user->notify(new CommentNotification($collect));
        }
        return response()->json('Comment posted succefully !!',200);
    }

    public function reply(CommentRequest $request){
        $product= Product::where('id',$request->product_id)->first();
        $cmt = Comment::where('id',$request->comment_id)->first();

        $comment = new Comment;
        $comment->product_id = $request->product_id;
        $comment->user_id = Auth::id();
        $comment->reply_id = $request->comment_id;
        $comment->body = $request->comment;
        $comment->save();
        //notification part
        if($cmt->user_id != Auth::id()){
            $collect = collect(
                ['id'=>$product->id,
                'cover'=>Auth::user()->cover,
                'user'=>Auth::user()->name,
                'slug'=>$product->slug,
                'productid'=>$product->id,
                'message'=>"replied on your comment"]);
            $cmt->user->notify(new CommentNotification($collect));
        }
        //notification part
        if($cmt->user_id == Auth::id()){
            $cmt = Comment::where('reply_id',$request->comment_id)
                           ->where('user_id','!=',Auth::id())
                           ->get()->unique('user_id');

            if($cmt->count() >0){
                $collect = collect(
                ['id'=>$product->id,
                'cover'=>Auth::user()->cover,
                'user'=>Auth::user()->name,
                'slug'=>$product->slug,
                'productid'=>$product->id,
                'message'=>Auth::user()->name." replied back"]);
                foreach($cmt as $c){
                    $c->user->notify(new CommentNotification($collect));
                }
            }
        }
        return response()->json('replied posted succefully !!',200);
    }

    public function commentDelete($id){

        $comment = Comment::where('id',$id)->first();
        if(Auth::id() == $comment->user_id){
            $comment->replies()->delete();
            $comment->delete();
            //Auth::user()->notification->delete();
            return response()->json('comment deleted succefully',200);
        }
        return response()->json('unauthorized access',200);
    }

}
