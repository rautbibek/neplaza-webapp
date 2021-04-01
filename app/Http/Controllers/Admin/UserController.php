<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::orderBy('product_count','desc');
              
        if(request()->has('search') && request('search') !== null){
            $user->where('name','LIKE', "%".request('search')."%")->orWhere('email','LIKE', "%".request('search')."%");
        }
        $result = $user->with('role')->withCount('product')
                       ->simplePaginate(30);
        return response()->json($result,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user= User::select('id','name','city_id','nhood_id','email','phone')->where('id',$id)->with(['product','product.image','city','nhood','report'])
                                    ->withCount('product')
                                    ->first();
        
        $urgent= Product::where('user_id',$id)->where('emergency_sell',true)->count();
        $feature= Product::where('user_id',$id)->where('premium',true)->count();
        $sold= Product::where('user_id',$id)->where('sold',true)->count();
        $deleted= Product::where('user_id',$id)->where('deleted',true)->count();
        
        
        return view('admin.detail.userDetail',compact('user','urgent','feature','deleted','sold'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($request->role_id){
           $user->role_id = $request->role_id; 
        }
        $user->block_by_admin = $request->block;
        $user->update();
        return response()->json('action performed succefully ',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user= User::findOrFail($id);
        if($user->product->count()<1){
            if(Storage::disk('public')->exists('profle/'.'/'.$user->image)){
                Storage::disk('public')->delete('profile/'.'/'.$user->image);
            }
            $user->comment()->delete();
            $user->notifications()->delete();
            $user->delete();
            
            return response()->json('user deleted succefully',200);
        }
        
        return response()->json('user cannot be deleted user has '.$user->product->count().' Ads',200);
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
     }
}
