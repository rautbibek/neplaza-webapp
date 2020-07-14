<?php

namespace App\Http\Middleware;

use Closure;

class BanUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->block_by_admin) {
			$message = 'Your account has been blocked by '.config('app.name');
			auth()->logout();     
			return redirect()->route('login')->withMessage($message); 
        }
        return $next($request);
    }
}
