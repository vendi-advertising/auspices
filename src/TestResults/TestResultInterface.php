<?php

namespace App\TestResults;

use App\TestResults;

interface TestResultInterface
{

    public const RESULT_TYPE_SUCCESS = 1;

    public const RESULT_TYPE_FAILURE = 2;

    public const RESULT_TYPE_INDETERMINATE = 3;

    public function get_result_type() : int;

    public function get_result_message() : ?string;

    public function get_result_extended_information();
}
