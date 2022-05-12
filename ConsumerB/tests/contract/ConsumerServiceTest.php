<?php

use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PHPUnit\Framework\TestCase;
use Tomskii26\ConsumerB\Service\ProductService;

class ConsumerServiceTest extends TestCase
{
    public function testGetProductsEndpoint()
    {
        $matcher = new Matcher();

        //create your expected request from the consumer
        $request = new ConsumerRequest();
        $request
            ->setMethod('GET')
            ->setPath('/api/products')
            ->addHeader('Content-Type', 'application/json');

        //create your expected response from the provider
        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'data' => []
            ]);

        // create a configuration that reflects the server that was started. You can create a custom MockServerConfigInterface if needed  
        $config = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->uponReceiving('a get request to /api/products')
            ->with($request)
            ->willRespondWith($response);
        
        $service = new ProductService($config->getBaseUri());
        $result = $service->getProducts(); 
        
        $builder->verify();
        $this->assertEquals(true, true);
    }
}