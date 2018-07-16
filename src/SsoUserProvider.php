<?php

namespace Cblink\Sso;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class SsoUserProvider extends DatabaseUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $appId = Cache::get($credentials['ticket']);

        if (!$appId) {
            abort(401, 'invalid ticket');
        }

        $user = DB::table(config('sso.table'))->where('app_id', $appId)->first();

        return $this->getGenericUser($user);
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        return  Cache::pull($credentials['ticket']);
    }
}