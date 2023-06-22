<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductOfferPrice
{
    private $value;

    public function __construct($value = null)
    {
        Assertion::notNull($value);
        Assertion::float($value);
        Assertion::min($value, 0.00);
        Assertion::max($value, 10000000.00);
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
