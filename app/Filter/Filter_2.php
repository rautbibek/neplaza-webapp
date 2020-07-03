<?php

 namespace App\Filter;
 use Closure;

 class filter_2{
     public function handle($request ,Closure $next){
        if(!request()->has('filter_2_id') && request('filter_2_id') == null){
            return $next($request);
        }

        $builder = $next($request);
        return $builder->whereIn('filter_2_id',request('filter_2_id'));
     }
 }
