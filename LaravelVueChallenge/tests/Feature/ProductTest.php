<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_GetPrducts()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_create_product()
    {
        $response = $this->post('api/add', [
            "name" => "Test product",
            "description" => "this is test of descripton product",
            "price" => 300,
            "image" => "https://m.media-amazon.com/images/I/61AwGDDZd3L._SL1500_.jpg"
        ]);
        
    

        $response->assertStatus(200);
    }






}
