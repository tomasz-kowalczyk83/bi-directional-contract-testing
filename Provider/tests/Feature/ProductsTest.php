<?php

namespace Tests\Feature;

use App\Models\Product;
use Spectator\Spectator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;




class ProductsTest extends TestCase
{
    use DatabaseMigrations;

    protected $id;

    public function setUp(): void
    {
        parent::setup();

        $product = Product::factory()->create();
        $this->id = $product->id;

        // Add Spectator
        Spectator::using('openapi.yaml');
    }

    public function testListOfProductsEndpoint ()
    {
        $this
            ->getJson('/api/products')
            ->assertValidRequest()
            ->assertValidResponse(200);
    }

    public function testGetProductEndpoint() 
    {
        echo $this->id;
        $this
            ->getJson("/api/products/{$this->id}")
            ->assertValidRequest()
            ->assertValidResponse(200);
    }
}