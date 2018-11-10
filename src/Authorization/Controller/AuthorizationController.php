<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 3:09 PM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authentication\Service\UserService;
use Kiyon\Laravel\Foundation\Routing\Controller;

class AuthorizationController extends Controller
{

    /**
     * 获取当前用户权限
     *
     * @param UserService $userService
     * @return mixed
     */
    public function abilities(UserService $userService)
    {
        $abilities = $userService->getAllAbilities(auth()->user());

        return $this->respond($abilities);
    }
}