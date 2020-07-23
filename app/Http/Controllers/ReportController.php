<?php

namespace App\Http\Controllers;
use App\Report;
use App\Mail\ReportMail;
use App\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(Request $request){
        $this->validate($request,[
        'email' => 'required',
        'reason'  => 'required',
        'description'=>'required',
        'product' =>'required',
        'user_id' =>'required',
        'product_id' =>'required',
      ]);
      
      $product = Product::select('id','slug','user_id','created_at')->where('id',$request->product_id)->with('user')->first();
      if($product->user->valid_email !=''){
        Mail::to($product->user->email)->queue(new ReportMail($product));
      }
      $report = new Report();
      $report->reported_by = $request->email; 
      $report->user_id = $request->user_id;
      $report->product_id = $request->product_id;
      $report->product = $request->product;   
      $report->reason_for_report = $request->reason;
      $report->description = $request->description;  
      $report->save();
      
      $message = "Thank you for your feedback & support";
      return response()->json($message,200);
      
    }
}
