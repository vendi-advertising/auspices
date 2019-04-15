<?php

namespace App\Test\TestResults;


use App\TestResults\AbstractTestResult;
use App\TestResults\FailResult;
use App\TestResults\IndeterminateResult;
use App\TestResults\SuccessResult;
use App\TestResults\TestResultInterface;

use PHPUnit\Framework\TestCase;

class TestResultsTest extends TestCase
{
    public function test_get_result_type()
    {
        //Just making sure these codes are correct, no typos
        $this->assertSame(TestResultInterface::RESULT_TYPE_FAILURE, (new FailResult())->get_result_type());
        $this->assertSame(TestResultInterface::RESULT_TYPE_SUCCESS, (new SuccessResult())->get_result_type());
        $this->assertSame(TestResultInterface::RESULT_TYPE_INDETERMINATE, (new IndeterminateResult())->get_result_type());
    }

    public function test_invalid_result_type()
    {
        //We only support three result type currently, and that is hard-coded
        //into the abstract class. Below we are passing a known invalid number
        //force an exception
        $this->expectException(\InvalidArgumentException::class);

        $class = new class(5) extends AbstractTestResult
        {
            public function __construct(int $type)
            {
                parent::__construct($type);
            }
        };
    }

    public function test_get_additional_information_works()
    {
        $message = 'Hello world';
        $data = [
            'alpha' => 'beta',
            true,
        ];

        $class = new class(TestResultInterface::RESULT_TYPE_INDETERMINATE, $message, $data) extends AbstractTestResult
        {
            public function __construct(int $result_type, string $message, $extended_information)
            {
                parent::__construct($result_type, $message, $extended_information);
            }
        };

        //The message is always a string
        $this->assertSame($message, $class->get_result_message());

        //Extended information structure is encouraged to be an array but
        //that is not enforced by anything.
        $this->assertSame($data, $class->get_result_extended_information());
    }
}
