<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class OnlineMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){
        $users_to_offline = User::where('lastActivity','<',now());
        $users_to_online = User::where('lastActivity','>',now());

        if(!empty($users_to_offline)){
            $users_to_offline->update(['onlineStatus'=>false]);
        }
        if(!empty($users_to_online)){
            $users_to_online->update(['onlineStatus'=>true]);
        }
        if(auth()->check()){
            $cache_value = Cache::put('user-is-online',auth()->id(),Carbon::now()->addMinute(1));
            $user = User::find(Cache::get('user-is-online'));
            $user->lastActivity = now()->addMinute(1);
            $user->onlineStatus = true;
            $user->save();
        }elseif (!auth()->check() && filled(Cache::get('user-is-online'))){
            $user = User::find(Cache::get('user-is-online'));
            if(!empty($user)){
                $user->onlineStatus = false;
                $user->save();
            }
        }
        return $next($request);
    }
}
