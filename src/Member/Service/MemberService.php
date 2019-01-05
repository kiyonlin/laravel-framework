<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 11:17 PM
 */

namespace Kiyon\Laravel\Member\Service;


use Kiyon\Laravel\Foundation\Service\RestfulService;
use Kiyon\Laravel\Member\Contracts\MemberRepositoryContract;

class MemberService
{
    use RestfulService;

    /** @var MemberRepositoryContract $repo */
    protected $repo;

    public function __construct(MemberRepositoryContract $repo)
    {
        $this->repo = $repo;
    }
}