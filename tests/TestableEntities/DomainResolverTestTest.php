<?php

namespace App\Test\TestableEntities;

use App\TestableEntities\Network\DomainResolverTest;
use PHPUnit\Framework\TestCase;

class DomainResolverTestTest extends TestCase
{
    public function test_it()
    {
        $obj = new DomainResolverTest('vendiadvertising.com', '104.25.145.37', '8.8.8.8');
        $obj->run_test();

        $this->assertTrue(true);
    }
}
