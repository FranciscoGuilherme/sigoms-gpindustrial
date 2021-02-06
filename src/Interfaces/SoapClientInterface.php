<?php

namespace App\Interfaces;

interface SoapClientInterface
{
    /**
     * @param string $wsdl
     * @param string $token
     * 
     * @throws \Exception
     */
    public function connect(string $wsdl, string $token): void;

    /**
     * @param string $resource
     * @param array $params
     */
    public function request(string $resource, array $params = []);
}