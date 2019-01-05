<?php
/**
 * Created by PhpStorm.
 * User: hdd
 * Date: 17-9-6
 * Time: 下午2:39
 */

namespace Kiyon\Laravel\Foundation\Testing;

use Mockery;
use phpmock\mockery\PHPMockery;

trait WithMock
{

    /**
     * @param string $namespace
     * @param string $function
     * @return Mockery\Expectation
     */
    public function mockFunc($namespace, $function)
    {
        return PHPMockery::mock($namespace, $function);
    }
}
