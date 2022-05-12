<?php

namespace Tomskii26\ConsumerB\Service;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

class ProductService
{
    /** @var Client */
    private $httpClient;
    /** @var string */
    private $baseUri;

    public function __construct(string $baseUri)
    {
        $this->httpClient = new Client();
        $this->baseUri = $baseUri;
    }

    public function getProducts()
    {
        $response = $this->httpClient->get(new Uri("{$this->baseUri}/api/products"), [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $body = $response->getBody();
        $object = \json_decode($body);
        
        return $object;
    }

    public function getProduct()
    {

    }
}