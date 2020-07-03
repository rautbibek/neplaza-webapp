@extends('layouts.app')
@section('content')
  <!-- Navbar -->
<div class="container p-5">
    <div>
        @foreach (Auth::user()->notifications as $noti)
            <p>{{$noti->type}}</p>
            <hr>
        @endforeach
    </div>
</div>
@endsection