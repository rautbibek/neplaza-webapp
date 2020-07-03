@extends('layouts.admin')

@section('content')
        
        <div>
            
            <admin-category></admin-category> 
            
        </div>
        
@endsection
<script type="text/javascript">
    window.Auth ={!! json_encode([
        'loggedIn' => false,
    ]) !!}
</script>