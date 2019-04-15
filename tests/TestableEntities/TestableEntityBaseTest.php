<?php

namespace App\Test\TestableEntities;

use App\TestableEntities\TestableEntityBase;
use PHPUnit\Framework\TestCase;

class TestableEntityBaseTest extends TestCase
{
    public function test_adders()
    {
        $obj = new class('test') extends TestableEntityBase
        {
            public function run_test()
            {

            }

            public function reset_test_results()
            {
                $this->_results = [];
            }
        };

        $this->assertCount(0, $obj->get_test_results());
        $obj->add_indeterminate_result();
        $this->assertFalse($obj->is_success());


        $obj->reset_test_results();
        $this->assertCount(0, $obj->get_test_results());
        $obj->add_failure();
        $this->assertFalse($obj->is_success());

        $obj->reset_test_results();
        $this->assertCount(0, $obj->get_test_results());
        $obj->add_success();
        $this->assertTrue($obj->is_success());

        $obj->reset_test_results();
        $this->assertCount(0, $obj->get_test_results());
        $this->assertFalse($obj->is_success());

        $this->assertSame('test', $obj->get_name());
    }
}
