<?php

namespace App\TestableEntities\Network;

use App\TestableEntities\TestableEntityBase;

final class UdpSocketConnectionTest extends SocketConnectionTest
{
    public function __construct(string $address, int $port)
    {
        parent::__construct('UDP Socket', \SOCK_DGRAM, \SOL_UDP, $address, $port);
    }

    final public function get_socket_url_transport() : string
    {
        return 'udp';
    }
}
