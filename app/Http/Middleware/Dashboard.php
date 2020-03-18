<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use Closure;

class Dashboard
{

    public function handle($request, Closure $next)
    {
        if(!auth()->check())
        {
            return redirect('/login');
        }

        if(!auth()->user()->can('use-dashboard'))
        {
            throw new AuthException();
        }

        return $next($request);
    }
}
