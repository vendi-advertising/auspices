<?php

namespace App\TestableEntities;

use App\TestResults\FailResult;
use App\TestResults\IndeterminateResult;
use App\TestResults\SuccessResult;
use App\TestResults\TestResultInterface;

abstract class TestableEntityBase implements TestableEntityInterface
{
    private $_name;

    protected $_results = [];

    public function __construct(string $name)
    {
        $this->_name = $name;
    }

    public function get_name() : string
    {
        return $this->_name;
    }

    public function get_test_results() : array
    {
        return $this->_results;
    }

    public function setup_test()
    {
        //NOOP
    }

    public function cleanup_test()
    {
        //NOOP
    }

    public function add_test_result(TestResultInterface $result)
    {
        $this->_results[] = $result;
    }

    public function add_success()
    {
        $this->add_test_result(new SuccessResult());
    }

    public function add_failure(string $message = null, $extended_information = null)
    {
        $this->add_test_result(new FailResult($message, $extended_information));
    }

    public function add_indeterminate_result(string $message = null, $extended_information = null)
    {
        $this->add_test_result(new IndeterminateResult($message, $extended_information));
    }

    public function is_success() : bool
    {
        //All tests must send at least one success result
        if(0 === count($this->get_test_results())){
            return false;
        }

        //If any of the results were indeterminate or a failure, the entire test
        //is considered not successful.
        foreach($this->get_test_results() as $result){
            if(TestResultInterface::RESULT_TYPE_SUCCESS !== $result->get_result_type()){
                return false;
            }
        }

        return true;
    }

}
