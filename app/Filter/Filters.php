<?php

 namespace App\Filter;
 use Closure;

 class Filters{
     public function handle($request ,Closure $next){
        if(!request()->has('filter_id') && request('filter_id') == null){
            return $next($request);
        }

        $builder = $next($request);
        return $builder->whereIn('filter_id',request('filter_id'));
     }
 }
