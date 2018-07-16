<?php

namespace Cblink\Sso;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class SsoUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $appId = Cache::get($credentials['ticket']);

        if (!$appId) {
            abort(401, 'invalid ticket');
        }

        return DB::table('sso.table')->where('app_id', $appId)->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return  Cache::pull($credentials['ticket']);
    }
}