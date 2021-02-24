<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
class ContactController extends Controller
{
    public function index(){
        $contact = Contact::count();
        $seen = Contact::where('status',true)->count();
        $unseen = Contact::where('status',false)->count();
        
        return view('admin.contact',compact('contact','seen','unseen'));
    }

    public function allContact(){
        $contact = Contact::orderBy('status','asc')->latest()->simplePaginate(30);
        return response()->json($contact,200);
    }

    public function delete($id){
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return response()->json('Contact deleted succefully');
    }

    public function update($id){
        $contact = Contact::findOrFail($id);
        $contact->status = true;
        $contact->update();
        return response()->json('Contact information marked as read');
    }

}
