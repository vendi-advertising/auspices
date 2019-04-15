<?php

namespace App\TestResults;

class IndeterminateResult extends AbstractTestResult
{
    public function __construct(string $message = null, $extended_information = null)
    {
        return parent::__construct(self::RESULT_TYPE_INDETERMINATE, $message, $extended_information);
    }
}
