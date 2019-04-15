<?php

namespace App\TestableEntities\Network;

use App\TestableEntities\TestableEntityBase;

final class TcpSocketConnectionTest extends SocketConnectionTest
{
    public function __construct(string $address, int $port)
    {
        parent::__construct('TCP Socket', \SOCK_STREAM, \SOL_TCP, $address, $port);
    }

    final public function get_socket_url_transport() : string
    {
        return 'tcp';
    }
}
