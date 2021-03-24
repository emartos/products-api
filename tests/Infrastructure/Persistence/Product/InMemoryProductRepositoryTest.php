<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Product;

use App\Domain\Product\Product;
use App\Infrastructure\Persistence\Product\InMemoryProductRepository;
use Tests\TestCase;

class InMemoryProductRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $product = new Product('000001', "BV Lean leather ankle boots", "boots", 89000);

        $productRepository = new InMemoryProductRepository([1 => $product]);

        $this->assertEquals([$product], $productRepository->findAll());
    }

    public function testFilterByCategory()
    {
        $products = [
            1 => new Product('000001', "BV Lean leather ankle boots", "boots", 89000),
            2 => new Product('000002', "BV Lean leather ankle boots", "boots", 99000),
            3 => new Product('000003', "Ashlington leather ankle boots", 'boots', 71000),
        ];

        $productRepository = new InMemoryProductRepository();

        $this->assertEquals(array_values($products), $productRepository->filterByCategory('boots'));
    }

    public function testFilterByPrice()
    {
        $products = [
            1 => new Product('000001', "BV Lean leather ankle boots", "boots", 89000),
        ];

        $productRepository = new InMemoryProductRepository();

        $this->assertEquals(array_values($products), $productRepository->filterByPrice(89000));
    }
}
