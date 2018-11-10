<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 4:54 PM
 */

namespace Tests\Feature\Authorization;


use Kiyon\Laravel\Authentication\Model\User;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{

    /** @test */
    public function 权限中间件()
    {
        $user = create(User::class);
        dd($user);
    }
}