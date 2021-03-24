<?php
declare(strict_types=1);

namespace App\Application\Actions\Product;

use Psr\Http\Message\ResponseInterface as Response;

class FilterProductsByPriceAction extends ProductAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $price = (int) $this->resolveArg('price');
        $products = $this->productRepository->filterByPrice($price);

        $this->logger->info("Products list filtered by price was viewed.");

        return $this->respondWithData($products);
    }
}
