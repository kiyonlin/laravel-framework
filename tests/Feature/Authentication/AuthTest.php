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
    public function 用户登录需要用户名和密码()
    {
        $this->withExceptionHandling();

        $this->assertErrorsHas(
            $this->postJson(route('auth.login'), ['username' => ''])->json(),
            'username');

        $this->assertErrorsHas(
            $this->postJson(route('auth.login'), ['password' => ''])->json(),
            'password');
    }

    /** @test */
    public function 用户登录失败()
    {
        $this->withExceptionHandling();

        $this->postJson(route('auth.login'), ['username' => 'username', 'password' => 'password'])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function 用户被锁定()
    {
        // $this->withExceptionHandling();

        $user = create(User::class, ['locked' => true]);

        $this->postJson(route('auth.login'),
            ['username' => $user->mobile, 'password' => '111111'])
            ->assertStatus(Response::HTTP_LOCKED);
    }


    /** @test */
    public function 用户使用手机登录()
    {
        $user = create(User::class);

        $resp = $this->postJson(route('auth.login'),
            ['username' => $user->mobile, 'password' => '111111'])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertArrayHasKey('token', $resp);
    }

    /** @test */
    public function 用户使用email登录()
    {
        $user = create(User::class);

        $resp = $this->postJson(route('auth.login'),
            ['username' => $user->email, 'password' => '111111'])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertArrayHasKey('token', $resp);
    }

    /** @test */
    public function 用户使用用户名登录()
    {
        $user = create(User::class);

        $resp = $this->postJson(route('auth.login'),
            ['username' => $user->username, 'password' => '111111'])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertArrayHasKey('token', $resp);
    }

    /** @test */
    public function 注销用户()
    {
        $user = create(User::class);
        $token = auth()->tokenById($user->id);

        $this->getJson(route('auth.logout'),
            ['Authorization' => "Bearer {$token}"])
            ->assertStatus(Response::HTTP_OK);

        $this->assertNull(auth()->user());
    }

    /** @test */
    public function 刷新token()
    {
        $user = create(User::class);
        $token = auth()->tokenById($user->id);

        $resp = $this->getJson(route('auth.refresh'),
            ['Authorization' => "Bearer {$token}"])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertNotEquals($resp['token'], $token);
    }

    /** @test */
    public function 获取用户信息()
    {
        $user = create(User::class);
        $token = auth()->tokenById($user->id);

        $resp = $this->getJson(route('auth.info'),
            ['Authorization' => "Bearer {$token}"])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertEquals($resp['display_name'], $user->display_name);
    }
}