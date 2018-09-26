<?php

namespace App\Http\Middleware;

use Closure;

class TeachSectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (check_admin(5)) {
            //若users資料表內的admin欄為1，則下一個request，否則返回 /
            return $next($request);
        }
        $words = "你不是「教學組」管理員！";
        return  response()->view('layouts.error',compact('words'));
    }
}
