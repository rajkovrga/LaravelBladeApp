<?php

namespace App\Http\Middleware;

use Closure;
use phpDocumentor\Reflection\Location;

class Log
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
        $log = activity()->withProperties([
            'method' => $request->method(),
            'address' => $request->getClientIp(),
            'path' => '/' . $request->path()
        ]);

        if(auth()->check())
        {
            $log->withProperty('username',auth()->user()->username);
        }

        $log->log('');


        return $next($request);
    }
}
