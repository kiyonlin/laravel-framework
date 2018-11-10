<?php

namespace Tests\Feature\Authentication;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Http\Request;
use Mockery as m;
use Kiyon\Laravel\Authentication\Model\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\JWTGuard;

class AuthTest extends TestCase
{

    /** @test */
    public function 用户登录失败()
    {
        $this->postJson(route('auth.login'), ['username' => 'username', 'password' => 'password'])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function 用户使用手机登录()
    {
        $jwt = m::mock(JWT::class);
        $provider = m::mock(EloquentUserProvider::class);
        $guard = m::mock(JWTGuard::class, [$jwt, $provider, Request::create('/auth', 'POST')]);

        $guard->shouldReceive('attempt')->once()->andReturn('token');

        $user = create(User::class);

        $resp = $this->postJson(route('auth.login'), ['username' => $user->mobile, 'password' => '111111'])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        dd($resp);
    }
}