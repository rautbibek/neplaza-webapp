@extends('support.layout')
@push('meta')
<meta name="title" content="FAQ">
<meta name="description" content="Have a problem/question? Find your solution here or Contact Us.">
<meta property="og:title" content="FAQ">
@endpush
@section('content')
<nav aria-label="breadcrumb ">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item pull-right"><a href="/">Home</a></li>
            <li class="breadcrumb-item pull-right"><a href="/support">Support</a></li>
            <li class="breadcrumb-item active" aria-current="page">FAQ</li>
        </ol>
    </nav>
<faq></faq>

@endsection