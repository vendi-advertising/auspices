<?php

namespace App\TestResults;

class SuccessResult extends AbstractTestResult
{
    public function __construct()
    {
        return parent::__construct(self::RESULT_TYPE_SUCCESS);
    }
}
