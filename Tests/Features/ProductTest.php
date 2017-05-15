<?php

namespace IrishTitan\Handshake\Tests\Features;

use IrishTitan\Handshake\Core\App;
use IrishTitan\Handshake\Facades\Product;
use IrishTitan\Handshake\Exceptions\ProductNotFoundException;
use IrishTitan\Handshake\Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Get our class ready for testing.
     *
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function a_product_can_be_created_and_deleted()
    {
        $product = $this->createProduct();

        Product::findOrFail($product->id);

        $product->delete();

        $this->expectException(ProductNotFoundException::class);
        Product::findOrFail($product->id);
    }

    /** @test */
    public function images_can_be_added_to_a_product()
    {
        $product = $this->createProduct();

        $product->addImage('../../pub/media/phone.jpg');
        $product->addImage('../../pub/media/car.jpg');

        $images = $product->images()->pluck('file');

        $this->assertSame(2, count($images));
        $this->assertTrue(strpos($images[0], 'phone') ? true : false);
        $this->assertTrue(strpos($images[1], 'car') ? true : false);
    }

    /** @test */
    public function a_created_product_has_the_correct_data()
    {
        $product = $this->createProduct();

        $this->assertSame('SKU0001', $product->sku);
        $this->assertSame('Example Product', $product->name);
        $this->assertSame('25.0000', $product->weight);
        $this->assertSame('100.5000', $product->price);
    }

    /**
     * Create a product for testing.
     *
     * @return mixed
     */
    protected function createProduct()
    {
        return Product::create([
            'sku' => 'SKU0001',
            'name' => 'Example Product',
            'weight' => 25,
            'price' => 100.50
        ]);
    }

}