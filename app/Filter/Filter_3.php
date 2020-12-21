<?php

 namespace App\Filter;
 use Closure;

 class Filter_3{
     public function handle($request ,Closure $next){
        if(!request()->has('filter_3_id') && request('filter_3_id') == null){
            return $next($request);
        }

        $builder = $next($request);
        return $builder->whereIn('filter_3_id',request('filter_3_id'));
     }
 }
