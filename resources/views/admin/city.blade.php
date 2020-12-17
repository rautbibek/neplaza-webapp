@extends('layouts.layout')

@section('content')
        
        <div class="mt-5">
            
            <admin-city></admin-city> 
            
        </div>
        
@endsection
<script type="text/javascript">
    window.Auth ={!! json_encode([
        'loggedIn' => false,
    ]) !!}
</script>