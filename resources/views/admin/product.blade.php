@extends('layouts.layout')

@section('content')
        <div class="mt-5">
            <admin-product 
                :all_ad='{{$all_ad}}' 
                :feature_ad="{{$feature_ad}}" 
                :deleted_ad="{{$deleted_ad}}"
                :urgent_ad="{{$urgent_ad}}"
                :sold_ad="{{$sold_ad}}"
                >
            </admin-product>
        </div>
@endsection
