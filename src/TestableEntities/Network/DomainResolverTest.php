<?php

namespace App\TestableEntities\Network;

use App\TestableEntities\TestableEntityBase;
use Net_DNS2_Exception;
use Net_DNS2_Resolver;
use Net_DNS2_RR_A;
use Net_DNS2_RR_AAAA;

class DomainResolverTest extends TestableEntityBase
{
    private $domain_name;
    private $address;
    private $dns_servers;

    private $query_type;
    private $results;

    public function __construct(string $domain_name, string $address, $dns_servers = null)
    {
        parent::__construct('Domain Resolver');
        $this->domain_name = $domain_name;
        $this->address = $address;
        if($dns_servers){
            $this->dns_servers = is_array($dns_servers) ? $dns_servers : [$dns_servers];
        }
    }

    final public function get_resolver()
    {
        $options = [];
        if($this->dns_servers){
            $options['nameservers'] = $this->dns_servers;
        }

        return Net_DNS2_Resolver($options);
    }

    final public function run_test()
    {
        foreach($result->answer as $answer){
            if(!$answer instanceOf Net_DNS2_RR_A && !$answer instanceOf Net_DNS2_RR_AAAA){
                continue;
            }

            dump($answer);
        }
    }

    final public function is_address_valid() : bool
    {
        if(\filter_var($this->address, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4)){
            $this->query_type = 'A';
            return true;
        }

        if(\filter_var($this->address, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6)){
            $this->query_type = 'AAAA';
            return true;
        }

        $this->add_failure('The provided address was not a valid IPv4 or IPv6 address.');
        return false;
    }

    final public function can_resolve_dns()
    {
        try {
            $result = $this->get_resolver()->query($this->domain_name, 'A');
        } catch(Net_DNS2_Exception $e) {
            dump($e);
            $this->add_failure('Could not resolve domain name.', ['exception' => $e]);
            return;
        }
    }
}
