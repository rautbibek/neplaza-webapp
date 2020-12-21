<?php

 namespace App\Filter;
 use Closure;

 class Status{
     public function handle($request ,Closure $next){
        if(!request()->has('status_id') ){
            return $next($request);
        }

        $builder = $next($request);
        return $builder->whereIn('status_id',request('status_id'));
     }
 }
