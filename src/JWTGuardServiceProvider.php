<?php

namespace Korodo\JWTGuard;

use Illuminate\Auth\AuthManager;
use Illuminate\Support\ServiceProvider;

class JWTGuardServiceProvider extends ServiceProvider
{
    public function boot(AuthManager $auth)
    {
        $auth->extend('jwt', function ($app, $name, array $config) use ($auth) {
            return new JWTGuard($app['tymon.jwt.auth'], $auth->createUserProvider($config['provider']));
        });
    }
}
