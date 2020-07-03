<?php

 namespace App\Filter;
 use Closure;

 class Type{
     public function handle($request ,Closure $next){
        if(!request()->has('type_id')){
            return $next($request);
        }

        $builder = $next($request);
        return $builder->whereIn('type_id',request('type_id'));
     }
 }
