<?php

namespace App\TestableEntities;

interface TestableEntityInterface
{
    public function get_name() : string;

    public function run_test();

    public function setup_test();

    public function cleanup_test();

    public function get_test_results() : array;

    public function is_success() : bool;
}
