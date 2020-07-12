@extends('layouts.layout')

@section('content')
        
        <div class="mt-5">
            
            <admin-nhood></admin-nhood> 
            
        </div>
        
@endsection
<script type="text/javascript">
    window.Auth ={!! json_encode([
        'loggedIn' => false,
    ]) !!}
</script>