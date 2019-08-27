<?php

namespace Korodo\JWTGuard;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Tymon\JWTAuth\JWTAuth;

class JWTGuard implements Guard
{
    use GuardHelpers;

    /** @var JWTAuth */
    protected $auth;

    public function __construct(JWTAuth $auth, UserProvider $provider)
    {
        $this->provider = $provider;
        $this->auth = $auth;
    }

    public function user()
    {
        if ($this->user !== null) {
            return $this->user;
        }

        if ($this->auth->getToken()) {
            return $this->user = $this->auth->authenticate();
        }

        return null;
    }

    public function validate(array $credentials = [])
    {
        $this->user = $this->provider->retrieveByCredentials($credentials);

        return $this->provider->validateCredentials($this->user, $credentials);
    }

    public function getAuth()
    {
        return $this->auth;
    }
}
