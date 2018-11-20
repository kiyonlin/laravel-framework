<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 11:17 PM
 */

namespace Kiyon\Laravel\Staff\Service;


use Kiyon\Laravel\Staff\Contracts\StaffRepositoryContract;

class StaffService
{

    /** @var StaffRepositoryContract $repo */
    public $repo;

    public function __construct(StaffRepositoryContract $repo)
    {
        $this->repo = $repo;
    }
}