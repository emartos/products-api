<?php
declare(strict_types=1);

namespace Tests\Domain\Product;

use App\Domain\Product\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function productProvider()
    {
        return [
            ['000001', "BV Lean leather ankle boots", "boots", 89000],
        ];
    }

    /**
     * @dataProvider productProvider
     * @param string $sku
     * @param string $name
     * @param string $category
     * @param int    $price
     */
    public function testGetters(string $sku, string $name, string $category, int $price)
    {
        $product = new Product($sku, $name, $category, $price);

        $this->assertEquals($sku, $product->getSku());
        $this->assertEquals($name, $product->getName());
        $this->assertEquals($category, $product->getCategory());
        $this->assertEquals($price, $product->getPrice());
    }

    /**
     * @dataProvider productProvider
     * @param string $sku
     * @param string $name
     * @param string $category
     * @param int    $price
     */
    public function testJsonSerialize(string $sku, string $name, string $category, int $price)
    {
        $product = new Product($sku, $name, $category, $price);

        $expectedPayload = json_encode([
            'sku' => $sku,
            'name' => $name,
            'category' => $category,
            'price' => [
                'original' => $price,
                'final' => 62300,
                'discount_percentage' => '30%',
                'currency' => 'EUR',
            ],
        ]);

        $this->assertEquals($expectedPayload, json_encode($product));
    }
}
