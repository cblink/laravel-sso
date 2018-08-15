<?php

namespace Cblink\Sso;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class SsoUserProvider extends DatabaseUserProvider
{
    /**
     * @param array $credentials
     * @return \Illuminate\Auth\GenericUser|UserContract|null
     * @throws SsoException
     */
    public function retrieveByCredentials(array $credentials)
    {
        $appId = Cache::get(config('sso.cache_prefix') . $credentials['ticket']);

        if (!$appId) {
            abort(401, 'invalid ticket');
        }

        $sso = DB::table(config('sso.table'))->where('app_id', $appId)->first();

        $user = $this->getUser($sso);

        return $this->getGenericUser($user);
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        return  Cache::pull(config('sso.cache_prefix') . $credentials['ticket']);
    }

    /**
     * @param $sso
     * @return mixed
     * @throws SsoException
     */
    protected function getUser($sso)
    {
        $callback = config('sso.get_user_by_sso');

        if ($callback instanceof \Closure) {
            return $callback($sso) ?: $sso;
        } else {
            throw new SsoException('config sso.get_user_by_sso is not callable');
        }
    }
}