@extends('support.layout')
@push('meta')
<meta name="title" content="Privacy Policy">
<meta name="description" content=" Before you utilize the services of this website have a look at the terms of use privacy policy of the website.">
<meta property="og:title" content="Privacy Policy">
@endpush
@section('content')
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item pull-right"><a href="/">Home</a></li>
            <li class="breadcrumb-item pull-right"><a href="/support">Support</a></li>
            <li class="breadcrumb-item active" aria-current="page">Legal & Policy Information</li>
        </ol>
    </nav>
    <policy></policy>
@endsection