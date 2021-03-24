<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Product;

use App\Application\Actions\ActionPayload;
use App\Domain\Product\ProductRepository;
use App\Domain\Product\Product;
use DI\Container;
use Tests\TestCase;

class FilterProductsByPriceActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $products = [
            new Product('000001', "BV Lean leather ankle boots", "boots", 89000),
            new Product('000002', "BV Lean leather ankle boots", "boots", 99000),
            new Product('000003', "Ashlington leather ankle boots", 'boots', 71000),
            new Product('000004', "Naima embellished suede sandals", 'sandals', 79500),
            new Product('000005', "Nathane leather sneakers", 'sneakers', 59000),
        ];

        $expectedProducts = [
            new Product('000003', "Ashlington leather ankle boots", 'boots', 71000),
        ];

        $productRepositoryProphecy = $this->prophesize(ProductRepository::class);
        $productRepositoryProphecy
            ->filterByPrice(71000)
            ->willReturn([$expectedProducts])
            ->shouldBeCalledOnce();

        $container->set(ProductRepository::class, $productRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/products/price/71000');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$expectedProducts]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
