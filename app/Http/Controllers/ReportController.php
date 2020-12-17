<?php

namespace App\Http\Controllers;
use App\Report;
use Illuminate\Support\Facades\Auth;
use App\Mail\ReportMail;
use App\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(){
        return $this->middleware('auth');
    }

    public function report(Request $request){
        $this->validate($request,[
        'reason'  => 'required',
        'description'=>'required',
        'user_id' =>'required',
        'product_id' =>'required',
      ]);

      $product = Product::select('id','slug','user_id','created_at')
               ->where('id',$request->product_id)
               ->with(['user'=>function($q){
                 $q->select('id','name','email');
               }])->first();
      if($product->user->valid_email !=''){
        Mail::to($product->user->email)->queue(new ReportMail($product,$request->reason));
      }
      $report = new Report();
      $report->reported_by = Auth::user()->username;
      $report->user_id = $request->user_id;
      $report->product_id = $request->product_id;
      $report->reason_for_report = $request->reason;
      $report->description = $request->description;
      $report->save();
      $message = "Thank you for your feedback & support";
      return response()->json($message,200);

    }
}
