<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(){
        return view('support.support');
    }

    public function contact(){
        return view('support.contact');
    }

    public function faq(){
        return view('support.faq');
    }

    public function aboutUs(){
        return view('support.about');
    }

    public function truesAndSafety(){
        return view('support.safety');
    }

    public function legalAndPolicy(){
        return view('support.policy');
    }
}
