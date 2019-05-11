<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 10:51 PM
 */

namespace Tests;

class AuthTestCase extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }
}