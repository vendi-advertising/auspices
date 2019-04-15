<?php

namespace App\TestResults;

class FailResult extends AbstractTestResult
{
    public function __construct(string $message = null, $extended_information = null)
    {
        return parent::__construct(self::RESULT_TYPE_FAILURE, $message, $extended_information);
    }
}
