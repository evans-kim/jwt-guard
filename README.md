# JWT Guard

>tymon/jwt-auth:0.5* 패키지에 라라벨 커스텀 AuthGuard 드라이버를 추가하는 포크 입니다.
라라벨 5.4 미만에서 'jwt' 드라이버를 설정하면 auth() 헬퍼 함수 등을 사용할 수 있습니다.

>This is a fork of tymon/jwt-auth:0.5* package to support AuthGuard custom driver.
Below Laravel 5.4, It help you using `auth('api')` helper or `middleware('auth:api')` 
before use this please watch Laravel Document then check how to change auth driver.

### Install

```shell script
composer require tymon/jwt-auth korodo/jwt-guard:dev-master
```
### Register Service Providers

config/app.php
```php
    'providers'=>[
        ...
        App\Providers\RouteServiceProvider::class,
        \Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class,
        \Korodo\JWTGuard\JWTGuardServiceProvider::class,
        ...
    ]
```
config/auth.php

```php
'guards' => [
    ...
    'api' => [
        'driver' => 'jwt', // it was token
        'provider' => 'users',
    ],
    ...
],
```

```shell script
php artisan jwt:generate
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
