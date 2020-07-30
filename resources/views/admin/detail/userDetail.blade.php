@extends('layouts.layout')

@section('content')
        <div class="mt-5">
        <admin-user-detail :user="{{$user}}" :feature_ad="{{$feature}}" :urgent_ad="{{$urgent}}" :deleted_ad="{{$deleted}}" :sold_ad="{{$sold}}"></admin-user-detail>
        </div>
@endsection
