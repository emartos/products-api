<?php
declare(strict_types=1);

namespace App\Domain\Product;

use JsonSerializable;

class Product implements JsonSerializable
{
    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $category;

    /**
     * @var int
     */
    private $price;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var array
     */
    private $discountRules;

    /**
     * @var bool
     */
    private $applyGreaterDiscount;

    /**
     * @param string    $sku
     * @param string    $name
     * @param string    $category
     * @param int       $price
     * @param string    $currency
     */
    public function __construct(string $sku, string $name, string $category, int $price, string $currency = 'EUR')
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->currency = $currency;
        $this->discountRules = [
            'category' => [
                'boots' => 30,
            ],
            'sku' => [
                '000003' => 15,
            ]
        ];
        $this->applyGreaterDiscount = false;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return array
     */
    private function buildPrice(): array
    {
        $discountPercentage = $this->getDiscountPercentage();
        if (!is_null($discountPercentage)) {
            $discountPercentage .= '%';
        }

        return [
            'original' => $this->getPrice(),
            'final' => $this->getDiscountPrice(),
            'discount_percentage' => $discountPercentage,
            'currency' => $this->getCurrency(),
        ];
    }

    /**
     * @return int|null
     */
    private function getDiscountPercentage(): ?int
    {
        // Checks the discount for this product.
        // Considering that one product can match more than one discount rule,
        // we need an attribute to define if we take the greater or the lesser.
        $categoryDiscount = $this->discountRules['category'][$this->getCategory()] ?? 0;
        $skuDiscount = $this->discountRules['sku'][$this->getSku()] ?? 0;
        if ($this->applyGreaterDiscount) {
            if ($categoryDiscount > $skuDiscount) {
                $discount = $categoryDiscount;
            }
            else {
                $discount = $skuDiscount > 0 ? $skuDiscount : $categoryDiscount;
            }
        }
        elseif ($categoryDiscount < $skuDiscount) {
          $discount = $categoryDiscount;
        }
        else {
          $discount = $skuDiscount > 0 ? $skuDiscount : $categoryDiscount;
        }

        return $discount !== 0 ? $discount : null;
    }

    /**
     * @return int
     */
    private function getDiscountPrice(): int
    {
        $price = $this->getPrice();

        return (int) ($price - ($price * ($this->getDiscountPercentage() / 100)));
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'category' => $this->getCategory(),
            'price' => $this->buildPrice(),
        ];
    }
}
