<?php

namespace Kiyon\Laravel\Authentication\Model;

use Kiyon\Laravel\Authorization\Contracts\UserInterface;
use Kiyon\Laravel\Authorization\Traits\UserTrait;
use Kiyon\Laravel\Support\Model\BaseModel;

class User extends BaseModel implements UserInterface
{
    use UserTrait;
}