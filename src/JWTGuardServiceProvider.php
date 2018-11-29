<?php
/**
 * Created by PhpStorm.
 * User: evanskim
 * Date: 29/11/2018
 * Time: 10:40 AM
 */

namespace Korodo\JWTGuard;

use Auth;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider as ServiceProvider;

class JWTGuardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        Auth::extend('jwt', function ($app, $name, array $config) {

            return new JWTGuard(
                $name,
                Auth::createUserProvider($config['provider']),
                $app
            );
        });
    }
}