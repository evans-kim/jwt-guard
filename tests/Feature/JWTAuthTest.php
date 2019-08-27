<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JWTAuthTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * This Test is depends on Laravel Application. So, it could not execute alone.
     *
     * @return void
     */
    public function testAuthentication()
    {
        $user = User::where('email', 'test1234@test.est')->first();
        if($user){
            $user->delete();
        }
        $user = User::create([
            'name'=>'Tester',
            'email'=>'test1234@test.est',
            'password'=>'test1234'
        ]);

        $this->assertFalse( auth('api')->check() );

        auth('api')->setUser($user);

        $this->assertTrue( auth('api')->check() );

        $user->delete();

    }
}
