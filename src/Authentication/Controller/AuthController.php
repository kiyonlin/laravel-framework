<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 3:09 PM
 */

namespace Kiyon\Laravel\Authentication\Controller;


use Illuminate\Auth\AuthenticationException;
use Kiyon\Laravel\Authentication\Request\AuthRequest;
use Kiyon\Laravel\Foundation\Routing\Controller;

class AuthController extends Controller
{

    /**
     * 用户登录
     *
     * @return mixed
     * @throws AuthenticationException
     */
    public function login(AuthRequest $request)
    {
        $credentials = request()->all();

        if ($token = $this->attemptLogin($credentials)) {
            if (auth()->user()->locked) {
                return $this->respondLocked();
            }

            return $this->respond(compact('token'));
        }

        throw new AuthenticationException();
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        auth()->logout(true);

        return $this->respond();
    }

    /**
     * 重新获取token
     *
     * @return mixed
     */
    public function refresh()
    {
        $newToken = auth()->refresh(true);

        return $this->respond(['token' => $newToken]);

    }

    /**
     * 获取用户信息
     *
     * @return mixed
     */
    public function info()
    {
        $info = array_only(auth()->user()->toArray(), ['display_name']);

        return $this->respond($info);
    }

    /**
     * 根据凭证尝试根据手机号、邮箱、用户名登录
     *
     * @param $credentials
     * @return bool
     */
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