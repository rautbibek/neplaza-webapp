@extends('support.layout')
@push('meta')
<meta name="title" content="Trust & Safety">
<meta name="description" content="Consider these to safeguard yourselves while using the services of this Platform">
<meta property="og:title" content="Trust & Safety">
@endpush
@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb ">
        <li class="breadcrumb-item pull-right"><a href="/">Home</a></li>
        <li class="breadcrumb-item pull-right"><a href="/support">Support</a></li>
        <li class="breadcrumb-item active" aria-current="page">Trust & Safty</li>
    </ol>
</nav>
<safety></safety>

@endsection