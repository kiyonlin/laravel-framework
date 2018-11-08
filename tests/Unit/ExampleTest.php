<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_test_some_thing()
    {
        $this->assertTrue(true);
    }
}
