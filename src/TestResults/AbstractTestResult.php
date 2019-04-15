<?php

namespace App\TestResults;

use Assert\Assertion;

abstract class AbstractTestResult implements TestResultInterface
{
    private $_result_type;

    private $_message;

    private $_extended_information;

    public function __construct(int $result_type, string $message = null, $extended_information = null)
    {
        Assertion::inArray($result_type, [self::RESULT_TYPE_SUCCESS, self::RESULT_TYPE_FAILURE, self::RESULT_TYPE_INDETERMINATE]);

        $this->_result_type = $result_type;
        $this->_message = $message;
        $this->_extended_information = $extended_information;
    }

    final public function get_result_type() : int
    {
        return $this->_result_type;
    }

    final public function get_result_message() : ?string
    {
        return $this->_message;
    }

    public function get_result_extended_information()
    {
        return $this->_extended_information;
    }
}
