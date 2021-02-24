<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Product;

class DashboardController extends Controller
{
    public function index(){ 
        $count = User::where('created_at','>=',Carbon::today()->subDays(7))->count();
        return view('admin.dashboard',compact('count'));
    }
    public function dayuser($day){
        $count = User::where('created_at','>=',Carbon::today()->subDays($day))->count();
        return response()->json($count);
    }

    public function dayproduct($day){
        $count = Product::where('created_at','>=',Carbon::today()->subDays($day))->where('deleted',false)->where('sold',false)->count();
        return response()->json($count);
    }

    public function countAll(){
        //featured ad , total user , urgent ad count
        $user = User::count();
        $seller = User::where('role_id',2)->count();
        $product = Product::count();
        $featured = Product::where('premium',true)->count(); 
        $urgent = Product::where('emergency_sell',true)->count(); 
        $deleted = Product::where('deleted',true)->count(); 
        return response()->json(['total_user'=>$user,
                                'total_seller'=>$seller,
                                'total_product'=>$product,
                                'featured_product'=>$featured,
                                'urgent_product'=>$urgent,
                                'deleted_product'=>$deleted]);
    }

    public function userGraph(){
        
        $users = User::select('id', 'created_at')
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m');
        });

    $usermcount = [];
    $userArr = [];

    foreach ($users as $key => $value) {
        $usermcount[(int)$key] = count($value);
    }

    $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    for ($i = 1; $i <= 12; $i++) {
        if (!empty($usermcount[$i])) {
            $userArr[$i]['count'] = $usermcount[$i];
        } else {
            $userArr[$i]['count'] = 0;
        }
        $userArr[$i]['month'] = $month[$i - 1];
    }

    return response()->json($userArr);
    }
}
