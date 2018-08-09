<?php

return [
    /**
     * sso table name
     */
    'table' => 'sso',

    /**
     * SSO controller will use this guard to login user.
     */
    'guard' => 'sso',

    /**
     * sso ticket cache
     */
    'cache_prefix' => 'laravel.sso.',

    /**
     * if your want to login in as a specific user, your can modify as you need. Or you can just return $sso.
     */
    'get_user_by_sso' => function ($sso) {

        //return User::find($sso['user_id']);

        return $sso;
    },
];