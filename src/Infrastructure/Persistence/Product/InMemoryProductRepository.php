<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Product;

use App\Domain\Product\ProductRepository;
use App\Domain\Product\Product;

class InMemoryProductRepository implements ProductRepository
{
    /**
     * @var Product[]
     */
    private $products;

    /**
     * InMemoryProductRepository constructor.
     *
     * @param array|null $products
     */
    public function __construct(array $products = null)
    {
        $this->products = $products ?? [
            1 => new Product('000001', "BV Lean leather ankle boots", "boots", 89000),
            2 => new Product('000002', "BV Lean leather ankle boots", "boots", 99000),
            3 => new Product('000003', "Ashlington leather ankle boots", 'boots', 71000),
            4 => new Product('000004', "Naima embellished suede sandals", 'sandals', 79500),
            5 => new Product('000005', "Nathane leather sneakers", 'sneakers', 59000),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->products);
    }

    /**
     * {@inheritdoc}
     */
    public function filterByCategory(string $category): array
    {
        $products = [];

        /** @var Product $product */
        foreach ($this->products as $product) {
            if ($category === $product->getCategory()) {
                $products[] = $product;
            }
        }

        return $products;
    }

    /**
     * {@inheritdoc}
     */
    public function filterByPrice(int $price): array
    {
        $products = [];

        /** @var Product $product */
        foreach ($this->products as $product) {
            if ($price === $product->getPrice()) {
                $products[] = $product;
            }
        }

        return $products;
    }

}
