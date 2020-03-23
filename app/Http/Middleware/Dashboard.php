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
            abort(403);
        }

        return $next($request);
    }
}
