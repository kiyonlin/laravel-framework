<?php

namespace Kiyon\Laravel\Foundation\Routing;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Kiyon\Laravel\Support\Controller\RestfulResponse;

class Controller extends BaseController
{

    use DispatchesJobs, ValidatesRequests, RestfulResponse;
}
