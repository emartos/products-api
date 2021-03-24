<?php
declare(strict_types=1);

namespace App\Domain\Product;

interface ProductRepository
{
    /**
     * @return Product[]
     */
    public function findAll(): array;

    /**
     * @param string $category
     * @return array
     */
    public function filterByCategory(string $category): array;

  /**
   * @param int $price
   * @return array
   */
    public function filterByPrice(int $price): array;
}
