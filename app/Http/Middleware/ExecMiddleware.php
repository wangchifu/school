<?php

namespace App\Http\Middleware;

use App\UserGroup;
use Closure;
use Illuminate\Support\Facades\Auth;

class ExecMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
        //若users_groups資料表內的group_id欄為1，則下一個request，否則返回 /
            $user_array = UserGroup::where('group_id','1')
                ->pluck('user_id')->toArray();
            if(in_array(Auth::user()->id,$user_array)){
                return $next($request);
            }
        }
        $words = "你不是行政人員！";
        return  response()->view('layouts.error',compact('words'));
    }
}
