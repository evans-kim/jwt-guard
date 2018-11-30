<?php
/**
 * Created by PhpStorm.
 * User: evanskim
 * Date: 28/11/2018
 * Time: 8:43 PM
 */

namespace Korodo\JWTGuard;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Cookie\CookieJar;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;

class JWTGuard implements Guard
{
    protected $name;
    /**
     * @var Authenticatable
     */
    protected $member;
    protected $provider;
    protected $tokenKey;
    protected $loggedOut=true;
    /**
     * @var JWTAuth
     */
    protected $auth;

    public function __construct($name, UserProvider $provider, $app)
    {
        $this->name = $name;
        $this->provider = $provider;
        $this->auth = $app['tymon.jwt.auth'];
    }
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return ! is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return ! $this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if($this->member){
            return $this->member;
        }

        $token = $this->auth->getToken();

        if(!$token)
            return null;

        $this->tokenKey = $token->get();


        $this->member = $this->auth->authenticate($this->tokenKey);


        if ($this->member && $this->tokenKey) {

            return $this->member;
        }

        if ($this->loggedOut) {
            return null;
        }
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        $user = $this->user();
        if (!$user) {
            return null;
        }

        return $this->member->getAuthIdentifier();
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return $this->provider->validateCredentials($this->user(), $credentials);
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return $this
     */
    public function setUser(Authenticatable $user)
    {
        $this->tokenKey = $this->auth->fromUser($user);
        $this->member = $user;
        $this->loggedOut = false;

        return $this;
    }

    public function login(Authenticatable $user, $remember = false)
    {
        return $this->setUser($user)->tokenKey;
    }

    public function loginUsingId($id, $remember = false)
    {
        $user = $this->provider->retrieveById($id);
        $this->setUser($user);
        return $this->tokenKey;
    }
}