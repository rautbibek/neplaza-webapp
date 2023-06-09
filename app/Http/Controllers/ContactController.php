<?php

namespace App\Http\Controllers;
use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function save(Request $request){
      $this->validate($request,[
        'name' => 'required',
        'email'=> 'email| required',
        'subject' =>'required',
        'message' => 'required',
      ]);
      $contact = new Contact();
      $contact->name = $request->name;
      $contact->email = $request->email;
      $contact->subject = $request->subject;
      $contact->message = $request->message;
      $contact->save();
      return response()->json("Thank you for contacting us ...");

    }
}
