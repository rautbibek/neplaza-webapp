<?php

namespace App\Http\Controllers\Admin;
use App\Report;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $total = Report::count();
        return view('admin.report',compact('total'));
    }

    public function reportApi(){
      
        $report = Report::with('product','user')->latest()->paginate(30);
        return response()->json($report,200);
    }

    public function delete($id){
        $report = Report::findOrFail($id);
        $report->delete();
        return response()->json('report deleted succefully');

    }

    public function update($id){
        $report = Report::findOrFail($id);
        $report->seen = true;
        $report->update();
        return response()->json('report reviewed succefully');

    }

}
