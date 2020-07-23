@extends('layouts.layout')

@section('content')
        <div class="mt-5">
            <admin-report :total="{{$total}}"></admin-report>
        </div>
@endsection
