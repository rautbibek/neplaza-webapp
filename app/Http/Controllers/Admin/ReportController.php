<?php

namespace App\Http\Controllers\Admin;
use App\Report;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $total = Report::count();
        return view('admin.report',compact('total'));
    }

    public function reportApi(){
        $report = Report::latest()->paginate(30);
        return response()->json($report,200);
    }

    public function delete($id){
        $report = Report::findOrFail($id);
        
        $report->delete();
        return response()->json('report deleted succefully');

    }

}
