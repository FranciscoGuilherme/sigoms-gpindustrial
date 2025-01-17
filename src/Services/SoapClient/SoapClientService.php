<?php

namespace App\Services\SoapClient;

use SoapClient;
use App\Interfaces\SoapClientInterface;

final class SoapClientService implements SoapClientInterface
{
    /**
     * @var SoapClient $soapClient
     */
    private SoapClient $soapClient;

    /**
     * {@inheritdoc}
     */
    public function connect(string $host, string $token): void
    {
        try {
            $this->soapClient = new SoapClient($host, [
                'cache_wsdl' => WSDL_CACHE_NONE,
                'stream_context' => stream_context_create([
                    'http' => [
                        'header' => 'Authorization: ' . $token
                    ],
                ]),
            ]);
            $this->soapClient->__setLocation($host);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function request(string $resource, array $params = [])
    {
        return $this->soapClient->__soapCall($resource, $params);
    }
}