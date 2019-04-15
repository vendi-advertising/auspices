<?php

namespace App\Test\TestableEntities;

use App\TestableEntities\Network\TcpSocketConnectionTest;
use App\TestableEntities\Network\UdpSocketConnectionTest;
use PHPUnit\Framework\TestCase;

class NetworkTest extends TestCase
{
    private static function get_sample_ipv4_address() : string
    {
        return '8.8.8.8';
    }

    private static function get_sample_ipv4_bad_address() : string
    {
        return '8.8.8';
    }

    public function test_tcp_connect()
    {
        //A connection to Google DNS should probably always work, as long as an
        //interet connection is there.
        $runner = new TcpSocketConnectionTest(self::get_sample_ipv4_address(), 443);
        $runner->run_test();
        $this->assertTrue($runner->is_success());
    }

    public function test_udp_connect()
    {
        //A connection to Google DNS should probably always work, as long as an
        //interet connection is there.
        $runner = new UdpSocketConnectionTest(self::get_sample_ipv4_address(), 443);
        $runner->run_test();
        $this->assertTrue($runner->is_success());
    }

    /**
     * @group slow
     */
    public function test_tcp_connect_timeout()
    {
        $runner = new TcpSocketConnectionTest(self::get_sample_ipv4_address(), 555);
        $runner->run_test();
        $this->assertFalse($runner->is_success());
    }

    public function test_run_test_bad_address()
    {
        $runner = new TcpSocketConnectionTest(self::get_sample_ipv4_bad_address(), 555);
        $runner->run_test();
        $this->assertFalse($runner->is_success());
    }

    /**
     * @covers \App\TestableEntities\Network\SocketConnectionTest
     * @dataProvider provider_for__is_address_valid
     */
    public function test_is_address_valid(bool $result, string $ip, int $port)
    {
        $runner = new TcpSocketConnectionTest($ip, $port);
        $this->assertSame($result, $runner->is_address_valid());
    }

    public function provider_for__is_address_valid() : array
    {
        //These could probably be changed to just anything, since this test
        //doesn't go out to the public internet.
        $good_ip_v4 = self::get_sample_ipv4_address();
        $bad_ip_v4 = self::get_sample_ipv4_bad_address();

        $good_ip_v6 = '2001:4860:4860::8888';
        $bad_ip_v6 = '2001:4860:4860';

        $good_port = 443;
        $bad_port = 0xffff + 1;


        return [
            [true, $good_ip_v4, $good_port],
            [true, $good_ip_v6, $good_port],

            [false, $bad_ip_v4, $good_port],
            [false, $bad_ip_v4, $bad_port],
            [false, $good_ip_v4, $bad_port],

            [false, $bad_ip_v6, $good_port],
            [false, $bad_ip_v6, $bad_port],
            [false, $good_ip_v6, $bad_port],
        ];
    }
}
