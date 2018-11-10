<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 3:09 PM
 */

namespace Kiyon\Laravel\Authentication\Controller;


use Illuminate\Auth\AuthenticationException;
use Kiyon\Laravel\Foundation\Routing\Controller;

class AuthController extends Controller
{

    /**
     * 用户登录
     */
    public function login()
    {
        $credentials = request()->all();

        if ($token = $this->attemptLogin($credentials)) {
            return $this->respond(compact('token'));
        }

        throw new AuthenticationException();
    }

    protected function attemptLogin($credentials)
    {
        foreach (['mobile', 'email', 'username'] as $username) {
            if ($token = auth()->attempt([
                "{$username}" => $credentials['username'],
                'password'    => $credentials['password'],
            ])) {
                return $token;
            }
        }

        return false;
    }
}