@extends('layouts.layout')

@section('content')
        <div class="mt-5">
        <admin-ad-detail :ad="{{$ad}}"></admin-ad-detail>
        
        </div>
@endsection
