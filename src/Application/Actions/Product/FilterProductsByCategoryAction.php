<?php
declare(strict_types=1);

namespace App\Application\Actions\Product;

use Psr\Http\Message\ResponseInterface as Response;

class FilterProductsByCategoryAction extends ProductAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $category = $this->resolveArg('category');
        $products = $this->productRepository->filterByCategory($category);

        $this->logger->info("Products list filtered by category was viewed.");

        return $this->respondWithData($products);
    }
}
