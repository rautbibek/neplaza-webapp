@extends('layouts.layout')

@section('content')

        <div class="mt-5">
        
            <admin-contact :contact='{{$contact}}' :seen="{{$seen}}" :unseen="{{$unseen}}"></admin-contact>

        </div>

@endsection