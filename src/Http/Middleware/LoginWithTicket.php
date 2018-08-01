<?php

namespace Cblink\Sso\Http\Middleware;

use Closure;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LoginWithTicket
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
        if (!$ticket = $request->get('ticket')) {
            return $next($request);
        }


        $appId = Cache::get(config('sso.cache_prefix') . $ticket);

        if (!$appId) {
            return $next($request);
        }

        $user = DB::table(config('sso.table'))->where('app_id', $appId)->first();

        if (!$user) {
            return $next($request);
        }

        $user = new GenericUser((array) $user);

        Auth::guard('sso')->login($user);

        return $next($request);
    }
}
