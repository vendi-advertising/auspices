<?php

namespace App\TestableEntities\Network;

use App\TestableEntities\TestableEntityBase;

abstract class SocketConnectionTest extends TestableEntityBase
{
    private $_type;
    private $_protocol;
    private $_address;
    private $_port;

    abstract public function get_socket_url_transport() : string;

    public function __construct(string $name, int $type, int $protocol, string $address, int $port)
    {
        parent::__construct($name);

        $this->_type = $type;
        $this->_protocol = $protocol;
        $this->_address = $address;
        $this->_port = $port;
    }

    final public function run_test()
    {
        if(!$this->is_address_valid()){
            return;
        }

        if(!$this->maybe_connect_socket()){
            return;
        }

        $this->add_success();
    }

    final public function is_address_valid() : bool
    {
        if(!\filter_var($this->_address, \FILTER_VALIDATE_IP)){
            $this->add_failure('The provided address was not a valid IPv4 or IPv6 address.');
            return false;
        }

        $port_options = [
            'options' => [
                'min_range' => 1,
                'max_range' => 0xffff
            ]
        ];

        if(!\filter_var($this->_port, \FILTER_VALIDATE_INT, $port_options)){
            $this->add_failure('The provided port was outside of the valid range.');
            return false;
        }

        return true;
    }

    final public function get_socket_url() : string
    {
        return sprintf(
            '%1$s://%2$s:%3$d',
            $this->get_socket_url_transport(),
            $this->_address,
            $this->_port
        );
    }

    final public function maybe_connect_socket() : bool
    {
        $result = @stream_socket_client(
            $this->get_socket_url(),
            $last_error_int,
            $last_error_str,
            2,
            \STREAM_CLIENT_CONNECT
        );

        if(false === $result){
            $details = [
                'system_error' => $last_error_str,
            ];
            $this->add_failure('The socket connection failed. See extended information for details', $details);
            return false;
        }

        return true;

    }
}
