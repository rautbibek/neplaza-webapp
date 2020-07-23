@extends('layouts.layout')

@section('content')
        <div class="mt-5">
        <admin-user-detail :user="{{$user}}"></admin-user-detail>
        </div>
@endsection
