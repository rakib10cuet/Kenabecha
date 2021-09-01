<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdmin{
    public function handle(Request $request, Closure $next){
        if(Auth::user()->utype == 1){
            return $next($request);
        }else{
            session()->flash('message','Fail to Login');
            return redirect()->route('login');
        }
    }
}
