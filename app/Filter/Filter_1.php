<?php

 namespace App\Filter;
 use Closure;

 class Filter_1{
     public function handle($request ,Closure $next){
        if(!request()->has('filter_1_id') && request('filter_1_id') == null){
            return $next($request);
        }

        $builder = $next($request);
        return $builder->whereIn('filter_1_id',request('filter_1_id'));
     }
 }
