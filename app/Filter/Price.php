<?php

 namespace App\Filter;
 use Closure;

 class Price{
     public function handle($request ,Closure $next){
        if(!request()->has('price')){
            return $next($request);
        }

        $builder = $next($request);
        return $builder->whereBetween('price',request('price'));
     }
 }
