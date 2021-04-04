@extends('support.layout')
@push('meta')
<meta name="title" content="About Us">
<meta name="description" content="Want to know more about us ?">
<meta property="og:title" content="About Us">
@endpush
@section('content')
<nav aria-label="breadcrumb ">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item pull-right"><a href="/">Home</a></li>
            <li class="breadcrumb-item pull-right"><a href="/support">Support</a></li>
            <li class="breadcrumb-item active" aria-current="page">About Us</li>
        </ol>
    </nav>
    <about></about>
@endsection